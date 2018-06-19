@extends('layouts.app')

@section('content')
    <h1>Neuen Kiosk erstellen</h1>

    {!! Form::open(['action' => 'KiosksController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('name', 'Name')}}
        {{Form::text('name', '', ['class' => 'form-control', ])}}
    </div>

    <div class="form-group">
        {{Form::label('info', 'Beschreibung')}}
        {{Form::textarea('info', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Beschreibung (Preise, Speisen, Angebote, ...)'])}}
    </div>

    <div class="form-group">
        {{Form::label('latitude', 'Breitengrad')}}
        {{Form::text('latitude', '', ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{Form::label('longitude', 'Längengrad')}}
        {{Form::text('longitude', '', ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{Form::file('picture')}}
    </div>

    {{Form::submit('Erstellen', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection