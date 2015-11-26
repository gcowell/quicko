@extends('app')

@section('content')

@foreach ($matches as $journey)

<div class = "body">
    <h3>Journey #{{ $journey->id }}</h3>
    <ul>
        <li>Pickup at: {{$journey->startaddress}}</li>
        <li>Dropoff at: {{$journey->endaddress}}</li>
        <li>{{$journey->startdistance}} miles from your pick-up point</li>
        <li>{{$journey->enddistance}} miles from your drop-off point</li>
       
    </ul>
</div>

@endforeach

@stop

