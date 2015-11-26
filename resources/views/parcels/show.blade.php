@extends('app')

@section('content')

<h1>Parcel {{ $parcel->id }}</h1>

<div class = "body">
    <ul>
        <li> {{$parcel->width}}</li>
        <li> {{$parcel->height}}</li>
        <li> {{$parcel->depth}}</li>
        <li> {{$parcel->weight}}</li>
        <li> {{$parcel->startaddress}}</li>
        <li> {{$parcel->endaddress}}</li>
        <li> {{$parcel->contents}}</li>
    </ul>
</div>

@stop