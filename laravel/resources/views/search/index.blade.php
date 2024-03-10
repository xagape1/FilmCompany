@extends('layouts/layoutMaster')

@section('title', 'Search Results')

@section('content')
@role('admin|pay')

<div class="genre-container">
    @if ($movies->isEmpty() && $series->isEmpty())
    <p>No results found.</p>
    @else
    <h2>Search Results</h2>

    @if (!$movies->isEmpty())
    <section class="genre-section">
        <h3>Movies</h3>
        <div class="movie-container">
            @foreach ($movies as $movie)
            <a href="{{ route('movies.show', $movie) }}" class="movie-link">
                <div class="movie">
                    <div class="movie-header">
                        <div class="movie-title">{{ $movie->title }}</div>
                        <div class="movie-actions">
                            @php
                            $isFavorite = Auth::user()->favoritedM->contains('id', $movie->id);
                            @endphp
                            <form method="post" class="favorite-form" action="{{ $isFavorite ? route('movies.unfavorite', $movie) : route('movies.favorite', $movie) }}" enctype="multipart/form-data">
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
                    @if($file->id == $movie->cover_id)
                    <img alt="Movie Cover" src='{{ asset("storage/{$file->filepath}") }}' class="movie-cover" />
                    @endif
                    @endforeach
                </div>
            </a> @endforeach
        </div>
    </section>
    @endif

    @if (!$series->isEmpty())
    <section class="search-results-section">
        <h3>Series</h3>
        <div class="movie-container">
            @foreach ($series as $serie)
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
                    <img alt="Series Cover" src='{{ asset("storage/{$file->filepath}") }}' class="movie-cover" />
                    @endif
                    @endforeach
                </div>
            </a> @endforeach
        </div>
    </section>
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
        font-size: 18px;
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
