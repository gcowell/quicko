@extends('app')

@section('content')

<h1>Send a Parcel</h1>

<hr/>

<div class="col-md-6">

{!! Form::open(['url' => 'parcels'])!!}

   @include('partials.parcelform')

{!! Form::close() !!}

</div>

<div class="col-md-4" id="mapcolumn">

    <div id="map">
    </div>

</div>

@stop