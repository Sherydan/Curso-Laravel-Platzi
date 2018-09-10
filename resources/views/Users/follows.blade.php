@extends('layouts.app')

@section('content')
<h1>{{$user->username}}</h1>

    <ul class="list-group">
        @foreach ($follows as $follow)
            <li class="list-group-item">{{$follow->username}}</li>
        @endforeach
    </ul>
@endsection