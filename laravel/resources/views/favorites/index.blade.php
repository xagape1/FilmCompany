@extends('layouts.layoutMaster')

@section('title', 'Favoritos')

@section('content')
@role('admin|pay')

<div class="card">
    <div class="header">
        <h1 class="title">FAVORITES</h1>
    </div>
    @if(count($favoriteMovies) <= 0 && count($favoriteSeries) <=0 && count($favoriteEpisodes) <=0) <p
        class="no-favorites">No favorite items found.</p>
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
                        <form method="post" class="favorite-form"
                            action="{{ route('movies.unfavorite', $favoriteMovie) }}" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="favorite-button">
                                <i class="fa-solid fa-star"></i> Remove Favorite
                            </button>
                        </form>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
        <div class="header">
            <h1 class="title">FAVORITES SERIES</h1>
        </div>
        <ul class="movie-list">
            @foreach ($favoriteSeries as $favoriteSerie)
            <li class="movie-item">
                <a href="{{ route('series.show', $favoriteSerie->id) }}">
                    <div class="movie">
                        <div class="header">{{ $favoriteSerie->title }}</div>
                        @foreach ($data['files'] as $file)
                        @if($file->id == $favoriteSerie->cover_id)
                        <img class="cover-image" alt="Portada Película"
                            src='{{ asset("storage/{$file->filepath}") }}' />
                        @endif
                        @endforeach
                        <form method="post" class="favorite-form"
                            action="{{ route('series.unfavorite', $favoriteSerie) }}" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="favorite-button">
                                <i class="fa-solid fa-star"></i> Remove Favorite
                            </button>
                        </form>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
        <div class="header">
            <h1 class="title">FAVORITES EPISODES</h1>
        </div>
        <ul class="movie-list">
            @foreach ($favoriteEpisodes as $favoriteEpisode)
            <li class="movie-item">
                <a href="{{ route('episode.show', $favoriteEpisode->id) }}">
                    <div class="movie">
                        <div class="header">{{ $favoriteEpisode->title }}</div>
                        @foreach ($data['files'] as $file)
                        @if($file->id == $favoriteEpisode->cover_id)
                        <img class="cover-image" alt="Portada Película"
                            src='{{ asset("storage/{$file->filepath}") }}' />
                        @endif
                        @endforeach
                        <form method="post" class="favorite-form"
                            action="{{ route('episodes.unfavorite', $favoriteEpisode) }}" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="favorite-button">
                                <i class="fa-solid fa-star"></i> Remove Favorite
                            </button>
                        </form>
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
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background-color: transparent;
        overflow: visible;
        list-style: none;
        max-width: 100%;

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

    .header {
        font-size: 28px;
        font-weight: bold;
    }

    .cover-image {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .favorite-form {
        display: inline-block;
    }

    .favorite-button {
        border: none;
        background: none;
        padding: 0;
        font-size: inherit;
        cursor: pointer;
    }
</style>

@endsection
