<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts.layoutMaster')

@section('title', 'Favoritos')

@section('content')
@role('admin|pay')
<div class="container card">
    <div>
        <h1>FAVORITES</h1>
    </div>
    @if(count($favoriteMovies) <= 0)
        <p>No se encontraron películas favoritas.</p>
    @else
        <ul class="movie-list">
            @foreach ($favoriteMovies as $favoriteMovie)
                <li class="movie-item">
                    <a href="{{ route('movies.show', $favoriteMovie->id) }}">
                        <div class="movie">
                            <div class="header">{{ $favoriteMovie->title }}</div>
                            @foreach ($data['files'] as $file)
                                @if($file->id == $favoriteMovie->cover_id)
                                    <img alt="Portada Película" src='{{ asset("storage/{$file->filepath}") }}' />
                                @endif
                            @endforeach
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endrole

<style>
    .movie-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .movie-item {
        margin: 10px;
    }

    .movie {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    img {
        max-width: 100%;
        height: auto;
    }
</style>

@endsection
