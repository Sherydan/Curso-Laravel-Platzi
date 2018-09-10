@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col col-md-12 col-lg-12 col-12">
        <form action="/auth/facebook/register" method="post">
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{$user->avatar}}" alt="" class="img-thumbnail">
                </div>
    
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-control-label">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}" readonly>
                    </div>
    
                    <div class="form-group">
                        <label for="email" class="form-control-label">Email</label>
                        <input name="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{$user->email}}" readonly>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
    
                <div class="card-body">
                    <div class="form-group">
                        <label for="username" class="form-control-label">Nombre de usuario</label>
                        <input name="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{old('username')}}">
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                        <div class="form-group">
                            <label for="password" class="form-control-label">Password</label>
                            <input name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{old('password')}}">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
    
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </div>
        </form>
    </div>
        

</div>
    
    
@endsection