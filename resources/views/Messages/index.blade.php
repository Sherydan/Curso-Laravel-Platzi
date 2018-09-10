@extends('layouts.app')

@section('content')
    <div class="row">
            @foreach ($messages as $message)
        <div class="col-md-6">
                
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
        @endforeach
    </div>

    <div class="row justify-content-center">
            <div class="mt-2">
                @if (count($messages))
                {{-- "appends" para agregar siempre algo a nuestro link y que al ir a la pagina 2 no se resetee la query
                    "except('page') para que el parametro page siempre este presente en el link y cambie de estado (page=2, page=3, etc."
                --}}
                
                    {{$messages->appends(Request::except('page'))->links()}}
                @endif
            </div>
        </div>
    
@endsection