@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>Das ist der Kebap-Guide! Hier finden Sie Informationen über Kebap-Kiosks in der Nähe.</p>

        @guest
            <p>
                <a class="btn btn-primary btn-lg" href="{{config('app.url', '')}}/login" role="button">Login</a>
                <a class="btn btn-primary btn-lg" href="{{config('app.url', '')}}/register" role="button">Register</a>
                <a class="btn btn-outline-primary btn-lg" href="{{config('app.url', '')}}/kiosks" role="button">Kiosks</a>
            </p>
        @else
            <p>
                <a class="btn btn-outline-primary btn-lg" href="{{config('app.url', '')}}/kiosks" role="button">Kiosks</a>
            </p>
        @endguest
    </div>
@endsection
