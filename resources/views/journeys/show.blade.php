@extends('app')

@section('content')

<h1>Journey {{ $journey->id }}</h1>

<div class = "body">
    <ul>
        <li>Starting Point: {{$journey->startaddress}}</li>
        <li>End Point: {{$journey->endaddress}}</li>
        <li>Date of Travel: {{$journey->traveldate}}</li>
    </ul>
</div>

@stop