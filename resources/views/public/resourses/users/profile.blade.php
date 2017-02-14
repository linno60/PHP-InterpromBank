@extends('public.layout.app')
@section('sidebar')
  11
@endsection

@section('content')
    <div class="row" style="margin-top: 40px;">
        <div class="col-md-4">
            <div class="card">
              <div class="card-block">
                <h4 class="card-title">{{ Auth::user()->name }}</h4>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">{{ Auth::user()->email }}</li>
              </ul>
              <div class="card-block">
                <a href="{{route('logout')}}" class="card-link">Выход</a>
              </div>
            </div>
        </div>
    </div>

@endsection