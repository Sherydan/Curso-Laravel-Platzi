@extends('layouts.app')

@section('content')
    @auth
    <div class="row justify-content-center mb-2">
        <div class="col-md-6">
            <h1>New Message</h1>
            {!! Form::open(['action' => 'MessagesController@store', 'method' => 'POST', 'files' => true]) !!}
                <div class="form-group ">
                    <input class="form-control @if($errors->has('message')) is-invalid @endif" type="text" name="message" id="message">
                    <div class="invalid-feedback">
                        @foreach ($errors->get('message') as $error)
                        <p>{{$error}}</p>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control-file @if($errors->has('image')) is-invalid @endif" name="image">
                    <div class="invalid-feedback">
                        @foreach ($errors->get('image') as $error)
                        <p>{{$error}}</p>
                        @endforeach
                    </div>
                </div>
                
            {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}
            {!! Form::close() !!}
            
        </div>
    </div>
    @endauth
    <div class="row">
            @forelse ($messages as $message)
            <div class="col-md-6">
                <div class="card m-1">
                    <img src="{{$message->image}}" alt="" class="card-img-top">
                    <div class="card-body">
                        <p class="card-text">
                            {{$message->content}}
                        </p>
                    <p class="text-muted">Writen by: <a href="users/{{$message->user->username}}">{{$message->user->username}}</a></p>
                    <a href="messages/{{$message->id}}" class="btn btn-primary">Show More</a>

                    <div class="float-right text-muted">{{$message->created_at}}</div>
                    </div>
                </div>
            </div>
            @empty
                <p>No messages found</p>
            @endforelse 
    </div>
    <div class="row justify-content-center">
        <div class="mt-2">
            @if (count($messages))
                {{$messages->links()}}
            @endif
        </div>
    </div>
@endsection