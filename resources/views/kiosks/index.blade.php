@extends('layouts.app')

@section('content')
    <h1>Kiosks</h1><br>
    @if(count($kiosks) > 0)
        @foreach($kiosks as $kiosk)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <img style="width: 100%" src="{{config('app.url')}}/storage/pictures/{{$kiosk->picture}}">
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h3><a href="{{config('app.url'), ''}}/kiosks/{{$kiosk->id}}">{{$kiosk->name}}</a></h3>
                            <small>Written on {{$kiosk->created_at}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
        {{$kiosks->links()}}
    @else
        <p>No Kiosks found!</p>
    @endif
@endsection