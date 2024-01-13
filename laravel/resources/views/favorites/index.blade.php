<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>
@php $configData = Helper::appClasses(); @endphp

@extends('layouts.layoutMaster')

@section('title', 'Favoritos')

@section('content') @role('admin|pay')

<div class="card">
    <div class="header">
        <h1 class="title">FAVORITES</h1>
    </div>
    @if(count($favoriteMovies) <= 0)
        <p class="no-favorites">No favorite movies found.</p>
    @else
        <ul class="movie-list">
            @foreach ($favoriteMovies as $favoriteMovie)
                <li class="movie-item">
                    <a href="{{ route('movies.show', $favoriteMovie->id) }}">
                        <div class="movie">
                            <div class="header">{{ $favoriteMovie->title }}</div>
                            @foreach ($data['files'] as $file)
                                @if($file->id == $favoriteMovie->cover_id)
                                    <img class="cover-image" alt="Portada Película"
                                        src='{{ asset("storage/{$file->filepath}") }}' />
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
    body {
        font-family: 'Nunito', sans-serif;
        margin: 0;
        padding: 0;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .title {
        text-align: center;
    }

    .no-favorites {
        text-align: center;
    }

    .movie-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .movie {
        border: 2px solid transparent;
        border-radius: 8px;
        text-align: center;
        transition: box-shadow 0.3s;
    }

    .movie:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .header {
        font-size: 28px;
        font-weight: bold;
    }

    .cover-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
</style>

@endsection
