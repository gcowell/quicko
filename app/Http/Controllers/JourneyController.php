<?php

namespace App\Http\Controllers;

use App\Journey;
use App\Http\Requests\CreateJourney;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;


class JourneyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }





    public function index()
    {

        $journeys = Auth::user()->journeys()->get();

        return view ('journeys.index')->with('journeys', $journeys);
    }






    public function show($id)
    {

        $journey = Auth::user()->journeys()->findOrFail($id);

        return view ('journeys.show')->with('journey', $journey);
    }






    public function create()
    {

        return view ('journeys.create');
    }






    public function store(CreateJourney $request)
    {

        $journey = new Journey($request->except('startpoint', 'endpoint'));
        $journey->startpoint = DB::raw("GeomFromText('POINT($request->startpoint)')");
        $journey->endpoint = DB::raw("GeomFromText('POINT($request->endpoint)')");
        Auth::user()->journeys()->save($journey);

        return redirect ('journeys');
    }


}
