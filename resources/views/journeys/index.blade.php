@extends('app')

@section('content')

<h1>Journeys</h1>


@foreach ($journeys as $journey)

<div class = "body">
    <h3><a href="{{ url('/journeys/' . $journey->id) }}">Journey #{{ $journey->id }}</a></h3>
    <ul>
        <li>Starting Point: {{$journey->startaddress}}</li>
        <li>End Point: {{$journey->endaddress}}</li>
        <li>Date of Travel: {{$journey->traveldate}}</li>
    </ul>
</div>

@endforeach

@stop