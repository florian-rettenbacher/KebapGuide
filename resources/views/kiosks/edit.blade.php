@extends('layouts.app')

@section('content')
    <h1>Kiosk ändern</h1>

    {!! Form::open(['action' => ['KiosksController@update' , $kiosk->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('name', 'Name')}}
        {{Form::text('name', $kiosk->name, ['class' => 'form-control', 'placeholder' => 'Name des Kiosks'])}}
    </div>

    <div class="form-group">
        {{Form::label('info', 'Beschreibung')}}
        {{Form::textarea('info', $kiosk->info, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Beschreibung (Preise, Speisen, Angebote, ...)'])}}
    </div>

    <div class="form-group">
        {{Form::label('latitude', 'Breitengrad')}}
        {{Form::text('latitude', $kiosk->latitude, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{Form::label('longitude', 'Längengrad')}}
        {{Form::text('longitude', $kiosk->longitude, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{Form::file('picture')}}
    </div>

    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Ändern', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection

