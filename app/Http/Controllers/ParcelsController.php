<?php

namespace App\Http\Controllers;

use App\Journey;
use App\Parcel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateParcel;
use Auth;
use DB;


class ParcelsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }





    public function index()
    {
        $parcels = Auth::user()->parcels()->get();

        return view ('parcels.index')->with('parcels', $parcels);
    }





    public function show($id)
    {
        $parcel = Auth::user()->parcels()->findOrFail($id);

        return view ('parcels.show')->with('parcel', $parcel);
    }





    public function create()
    {

        return view ('parcels.create');
    }






    public function store(CreateParcel $request)
    {

        $parcel = new Parcel($request->except('startpoint', 'endpoint'));

        //TODO move to parcel model
        $parcel->startpoint = DB::raw("GeomFromText('POINT($request->startpoint)')");
        $parcel->endpoint = DB::raw("GeomFromText('POINT($request->endpoint)')");
        //TODO move to parcel model

        Auth::user()->parcels()->save($parcel);


        return redirect ('parcels');
    }


    //Find journeys near parcel locations
    public function matchToJourney($id, $range)
    {
        $parcel = Auth::user()->parcels()->findOrFail($id);
        $journey = new Journey();
        $matches = $journey->findMatchingJourneys($parcel, $range);


        return view ('parcels.match')->with('matches', $matches);

    }

}
