<?php

namespace App\Http\Controllers;

use App\Journey;
use App\Parcel;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateParcel;
use Auth;
use DB;
Use Response;



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

        $parcel->startpoint = $parcel->createSpatialGeometry($request->startpoint);
        $parcel->endpoint = $parcel->createSpatialGeometry($request->endpoint);

        Auth::user()->parcels()->save($parcel);

        return redirect ('parcels');
    }






    //Find journeys near parcel locations
    public function matchToJourney(Request $request, $id, $range)
    {

        if($request->ajax())
        {
            $parcel = Auth::user()->parcels()->findOrFail($id);
            $parcel = $parcel->unpackPoints($parcel->id);
            $journey = new Journey();
            $matches = $journey->findMatchingJourneys($parcel, $range);
            $results = ['parcel' => $parcel, 'matches' => $matches];

            return ($results);
        }
        else
        {
            return view ('parcels.match');
        }

    }

}
