<p><h2>Locations:</h2></p>

<div class="form-group">
    {!! Form::label('startaddress', 'Where you want it picked up from: ') !!}
    {!! Form::text('startaddress', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('endaddress', 'Where you want it to be delivered to: ') !!}
    {!! Form::text('endaddress', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::button('Show on Map', ['class' => 'btn btn-default form-control', 'id' => 'show_on_map']) !!}
</div>

<p><h2>Dimensions:</h2></p>

<div class="form-group">
    {!! Form::label('width', 'Width: ') !!}
    {!! Form::text('width', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('height', 'Height: ') !!}
    {!! Form::text('height', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('depth', 'Depth: ') !!}
    {!! Form::text('depth', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('weight', 'Weight: ') !!}
    {!! Form::text('weight', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('contents', 'What is inside? ') !!}
    {!! Form::textarea('contents', null, ['class' => 'form-control', 'placeholder' => 'A brief description will do...']) !!}
</div>

<div class="form-group">
    {!! Form::hidden('startpoint', 'null', array('id' => 'startpoint')) !!}
    {!! Form::hidden('endpoint', 'null', array('id' => 'endpoint')) !!}
</div>

<div class="form-group">
    {!! Form::submit('Create Parcel', ['class' => 'btn btn-primary form-control']) !!}
</div>

@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif