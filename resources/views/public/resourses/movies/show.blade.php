@extends('public.layout.app')

@section('content')
    <h1>{{$movie->title}}</h1>
    <p>{{$movie->description}}</p>
    <button class="btn btn-primary">Подписаться</button>

@endsection