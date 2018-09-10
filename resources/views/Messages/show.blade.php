@extends('layouts.app')
@section('title')
    Show Message
@endsection

@section('content')
    <div class="row justify-content-center">
        
        <div class="card">
                <img src="{{ $message->image}}" class="card-img-top" alt="">
                <div class="card-body">
                    <p class="card-text">
                        {{$message->content}}
                    </p>
                </div>
                <div class="card-footer">
                    <p class="text-muted d-inline">{{$message->created_at}} Writen By: {{$message->user->username}}</p>
                    <a href="/" class="btn btn-primary float-right">Go Back</a>
                </div>
            </div>        
    </div>

    {{-- pasarle el id del post al componente de vue --}}
    
    <responses :message="{{ $message->id }}"></responses>
@endsection