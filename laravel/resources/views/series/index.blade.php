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
<div class="genre-container">
    @if(count($genres) <= 0) <p>No se encontraron géneros.</p>
        @else
        @php
        $hasSeries = false;
        @endphp

        @foreach ($genres as $genre)
        @php
        $seriesInGenre = $series->where('genre_id', $genre->id);
        $hasContentInGenre = $seriesInGenre->isNotEmpty();
        $hasSeries = $hasSeries || $hasContentInGenre;
        @endphp

        @if ($hasContentInGenre)
        <section class="genre-section">
            <h2>{{ $genre->name }}</h2>

            <!-- Series -->
            @if (count($seriesInGenre) > 0)
            <div class="series-container">
                @foreach ($seriesInGenre as $serie)
                <a href="{{ route('series.show', $serie) }}" class="movie-link">
                    <div class="movie">
                        <div class="movie-header">
                            <div class="movie-title">{{ $serie->title }}</div>
                            <div class="movie-actions">
                                @php
                                $isFavorite = Auth::user()->favoritedS->contains('id', $serie->id);
                                @endphp
                                <form method="post" class="favorite-form" action="{{ $isFavorite ? route('series.unfavorite', $serie) : route('series.favorite', $serie) }}" enctype="multipart/form-data">
                                    @csrf
                                    @if($isFavorite)
                                    @method('DELETE')
                                    @endif
                                    <button type="submit" class="favorite-button">
                                        <i class="{{ $isFavorite ? 'fa-solid' : 'fa-regular ' }} fa-star"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @foreach ($files as $file)
                        @if($file->id == $serie->cover_id)
                        <img alt="Portada Pelicula" src='{{ asset("storage/{$file->filepath}") }}' class="movie-cover" />
                        @endif
                        @endforeach
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </section>
        @endif
        @endforeach

        @if (!$hasSeries)
        <p class="movie-title">No series found, wait the maintenance.</p>
        @endif
        @endif
</div>
@endrole
@endsection

<style>
    .genre-container {
        margin: 20px;
    }

    .genre-section {
        margin-bottom: 30px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 20px;
    }

    .movie-container,
    .series-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .movie {
        border: 2px solid transparent;
        border-radius: 8px;
        text-align: center;
        transition: box-shadow 0.3s;
        max-width: 100%;
    }

    .movie:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .movie-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
    }

    .movie-title {
        font-size: 20px;
        font-weight: bold;
    }

    .favorite-form {
        display: inline-block;
    }

    .favorite-button {
        border: none;
        background: none;
        padding: 0;
        font-size: inherit;
        margin-right: 10px;
        margin: 5px;
        cursor: pointer;
    }

    .movie-cover {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
</style>