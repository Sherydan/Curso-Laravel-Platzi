@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Conversacion con {{ $conversation->users->except($user->id)->implode('name', ', ')}}
        </div>    

        <div class="card-body">
            @foreach ($conversation->privateMessages as $message)
            <div class="card-text">
                <p>{{$message->user->name}} dijo...</p>
                <p>{{$message->message}}</p>

                <p class="tex-muted">{{$message->created_at}}</p>
            </div>
            @endforeach
            
        </div>
        <div class="card-footer text-muted">

        </div>
    
    </div>    
@endsection