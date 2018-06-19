@extends('layouts.app')

@section('content')
    <style>
        #map {
            width: 100%;
            height: 400px;
            background-color: grey;
        }
    </style>

    <h1>Kiosk: {{$kiosk->name}}</h1>
    <hr>

    <div class="container">
        <div class="row">
            <div class="col">
                <div id="mapcanvas">
                    Laden von Google Maps...
                </div>

                <script>
                    function load() {
                        var mapcanvas = document.getElementById('mapcanvas');
                        mapcanvas.style.height = '100%';
                        mapcanvas.style.width = '100%';
                        var latlng = new google.maps.LatLng({{ $kiosk->latitude }}, {{ $kiosk->longitude }});
                        var myOptions = {
                            zoom: 15,
                            center: latlng,
                            mapTypeControl: false,
                            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
                        var marker = new google.maps.Marker({
                            position: latlng,
                            map: map,
                            title: "{{ $kiosk->name }}"
                        });
                    }

                    window.addEventListener("load", load, false);
                </script>
            </div>
            <div class="col">
                <img class="img-fluid" style="..." src="{{config('app.url')}}/storage/pictures/{{$kiosk->picture}}"><br><br>
            </div>
        </div>
    </div>
    <hr>

    <div class="container">
        {!! $kiosk->info !!}
    </div>

    <hr>
    <div class="container ">
        <small>Kiosk-Besitzer: {{$kiosk->admin->name}}</small>
    </div><br>
    <hr>

    @auth
        @if(Auth::user()->id == $kiosk->admin_id)
            <div class="form-group">
                <div class="form-row">
                    <div class="col">
                        <a href="{{config('app.url', '')}}/kiosks/{{$kiosk->id}}/edit" class="form-control btn btn-default">Edit</a>
                    </div>
                    <div class="col">
                        {!! Form::open(['action' => ['KiosksController@destroy', $kiosk->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'form-control btn btn-danger'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <h2>Kundenbewertungen:</h2>

    <div cotainer>
        <h3>Sterne: {{round($stars, 1)}}</h3>
    </div>

    <div class="container">
        @forelse($reviews as $review)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$review->title}}</h5>
                    <small>{{$review->user->name}} | {{$review->updated_at}}</small>
                    <br>
                    Stars: {{$review->stars}} / 5<br>
                    @if($review->body != "")
                    <hr>
                    {{$review->body}}
                    @endif

                    @auth
                        @if($review->user_id == auth()->user()->id)
                            <hr>
                            {!! Form::open(['action' => ['KiosksController@destroyReview', $kiosk->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'form-control btn btn-danger'])}}
                            {!! Form::close() !!}
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            Es sind noch keine Rezensionen vorhanden!
        @endforelse

        @auth
            <hr>
            <h2>Neue Rezension schreiben!</h2>
            {!! Form::open(['action' => 'KiosksController@storeReview', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {{Form::hidden('kiosk_id', $kiosk->id)}}
            <div class="form-group">
                {{Form::label('title', 'Titel')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder'=>'Titel Ihrer Rezension'])}}
            </div>

            <div class="form-group">
                {{Form::label('body', 'Text')}}
                {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Teilen Sie kurz Ihre Meinung zu dem Kiosk mit.'])}}
            </div>
            <div class="form-group">
                {{Form::label('stars', 'Sterne')}}

                <div class="input-group">
                    {{Form::selectRange('stars', 0, 5, 5, ['class' => 'custom-select'])}}
                    <div class="input-group-append">
                        <span class="input-group-text">/5</span>
                    </div>
                </div>
            </div>

            {{Form::submit('Erstellen', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        @endauth
    </div><br>

    <a href="{{config('app.url')}}/kiosks" class="btn btn-dark btn-block">Zurück</a><br>
@endsection