@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{config('app.url')}}/kiosks/create" class="btn btn-outline-primary btn-block">Neuer Kiosk</a><br>
                        <h3>Deine Kiosks</h3>
                        @if(count($kiosks) > 0)
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @foreach($kiosks as $kiosk)
                                    <tr>
                                        <td>{{ $kiosk->name }}</td>
                                        <td><a href="{{config('app.url')}}/kiosks/{{ $kiosk->id }}/edit" class="btn btn-default">Edit</a></td>
                                        <td>
                                            {!! Form::open(['action' => ['KiosksController@destroy', $kiosk->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'form-control btn btn-danger'])}}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>Sie haben noch keine Kiosks</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
