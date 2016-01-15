@extends('app')

@section('content')


<h1>My Parcels</h1>

@foreach ($parcels as $parcel)

<div class = "body">
    <h3><a href="{{ url('/parcels/' . $parcel->id) }}">Parcel #{{ $parcel->id }}</a></h3>
    <ul>
        <li>Size: {{$parcel->width}} x {{$parcel->height}} x {{$parcel->depth}}</li>
        <li>Weight: {{$parcel->weight}}</li>
        <li>Pickup at: {{$parcel->startaddress}}</li>
        <li>Dropoff at: {{$parcel->endaddress}}</li>
        <li>Contents: {{$parcel->contents}}</li>
        <li><a href="{{ url('/parcels/' . $parcel->id . '/' . 'default') }}">Find a Route for Parcel #{{ $parcel->id }}</a></li>
    </ul>
</div>

@endforeach


@stop