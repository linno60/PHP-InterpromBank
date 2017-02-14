@extends('public.layout.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-block">
              <h4 class="card-title text-xs-center">Регистрация</h4>
              <div class="card-text">
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                      {{ csrf_field() }}
                      
                      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">
                              @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('name') }}</strong>
                                  </span>
                              @endif
                            <div class="clearfix"></div>
                      </div>

                      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                            <div class="clearfix"></div>
                      </div>

                      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                              <input id="password" type="password" class="form-control" name="password" required placeholder="password">

                              @if ($errors->has('password'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                          <div class="clearfix"></div>
                      </div>

                      <div class="form-group">
                              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="password confirmation">
                          <div class="clearfix"></div>
                      </div>

                      <div class="form-group row">
                          <div class="col-md-6">
                              <button type="submit" class="btn btn-primary">
                                  Регистрация
                              </button>
                          </div>

                          <div class="col-md-6 text-xs-right">
                              <a href="{{route('login')}}">Авторизация</a>
                          </div>
                      </div>
                  </form>
              </div>
        </div>
    </div>
</div>
@endsection
