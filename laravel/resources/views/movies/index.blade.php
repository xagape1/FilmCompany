<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')

<div class="container">
    @if(count($movies) <= 0) <p>No se encontraron películas.</p>
        @else
        @foreach ($movies as $movie)
        <a href="{{ route('movies.show', $movie) }}">
            <div class="movie">
                <div class="header">{{ $movie->title }}</div>
                @foreach ($files as $file)
                @if($file->id == $movie->cover_id)
                <img alt="Portada Pelicula" src='{{ asset("storage/{$file->filepath}") }}' />
                @endif
                @endforeach
            </div>
        </a>
        @endforeach
        @endif
</div>



@endsection