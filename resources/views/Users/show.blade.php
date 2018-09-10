@extends('layouts.app')

@section('content')

    @if (session('success'))
        <div class="text-success">
            {{session('success')}}
        </div>
    @endif
    @if (!empty($user))
        <h1>{{$user->username}}</h1>
        <a href="/users/{{$user->username}}/follows" class="btn btn-link">
            Sigue a <span class="badge badge-primary">{{$user->follows->count()}}</span>
        </a>

        <a href="/users/{{$user->username}}/followers" class="btn btn-link">
            Seguidores <span class="badge badge-primary">{{$user->followers->count()}}</span>
        </a>
        @auth
        <!-- gate::allows me busca si los usuarios se siguen mutuamente ---> 
        @if (Gate::allows('dms', $user))
            <form action="/users/{{$user->username}}/dms" method="post" class="m-2">
                {{ csrf_field() }}
                <input type="text" name="message" id="message" class="form-control">
                <button type="submit" class="btn btn-success">Enviar DM</button>
            </form>
            
        @endif
            
            @if (Auth::user()->isFollowing($user))
                <form action="/users/{{$user->username}}/unfollow" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger">Unfollow</button>
                </form>
                
            @else
                <form action="/users/{{$user->username}}/follow" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary">Follow</button>
                </form>
            @endif
            
        @endauth
        <div class="row">
            @forelse ($user->messages as $message)
                <div class="col col-md-6 col-lg-6 col-12">
                    <div class="card m-2">
                        <img src="{{$message->image}}" alt="" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">
                                {{$message->content}}
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="text-muted d-inline">{{$message->created_at}} Writen By: {{$message->user->username}}</p>
                            
                        </div>
                    </div>
                </div>
            @empty
                <p>No messages found for this user</p>
            @endforelse
        </div>
    @else
        <div class="jumbotron text-center">
            <h1>User Not found</h1>
            <a href="/" class="btn btn-primary">Go Back</a>
        </div>
    @endif
@endsection