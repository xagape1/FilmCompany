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
@role('admin|pay')
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
                @php
                $isFavorite = Auth::user()->favorited->contains('id', $movie->id);
                @endphp
                <form method="post" style="display: inline-block;"
                    action="{{ $isFavorite ? route('movies.unfavorite', $movie) : route('movies.favorite', $movie) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if($isFavorite)
                    @method('DELETE')
                    @endif
                    <button id="quitar" type="submit">
                        <i class="{{ $isFavorite ? 'fa-regular' : 'fa-solid' }} fa-star"></i>
                    </button>
                </form>
            </div>
        </a>
        @endforeach
        @endif
</div>

@endrole

@endsection