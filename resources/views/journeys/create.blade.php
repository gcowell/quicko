@extends('app')

@section('content')

<h1>Create a Journey</h1>

<hr/>

<div class="col-md-6">

    {!! Form::open(['url' => 'journeys'])!!}

       @include('partials.journeyform')

    {!! Form::close() !!}

</div>

<div class="col-md-4" id="mapcolumn">

    <div id="map">
    </div>

</div>


@stop