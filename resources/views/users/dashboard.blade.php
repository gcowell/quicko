@extends('app')

@section('content')

<h1>{{$user->name}}'s Dashboard</h1>

<ul>

<li><a href="{{ url('/journeys') }}">View my Journeys</a></li>
<li><a href="{{ url('/parcels') }}">View my Parcels</a></li>

</ul>

@stop