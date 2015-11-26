<p><h2>Locations:</h2></p>

<div class="form-group">
    {!! Form::label('startaddress', 'Where you are travelling from: ') !!}
    {!! Form::text('startaddress', null, ['class' => 'form-control']) !!}
</div>



<div class="form-group">
    {!! Form::label('endaddress', 'Where you are going: ') !!}
    {!! Form::text('endaddress', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::button('Show on Map', ['class' => 'btn btn-default form-control', 'id' => 'show_on_map']) !!}
</div>


<p><h2>Timing</h2></p>

<div class="form-group">
    {!! Form::label('traveldate', 'Date of Travel: ') !!}
    {!! Form::input('date', 'traveldate', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::hidden('startpoint', 'null', array('id' => 'startpoint')) !!}
    {!! Form::hidden('endpoint', 'null', array('id' => 'endpoint')) !!}
</div>

<div class="form-group">
    {!! Form::submit('Create Journey', ['class' => 'btn btn-primary form-control']) !!}
</div>




@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif


