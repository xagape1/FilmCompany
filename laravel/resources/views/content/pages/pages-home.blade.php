@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
@role('admin|pay')
<div class="container">
    @if(count($genres) <= 0)
        <p>No se encontraron géneros.</p>
    @else
        @foreach ($genres as $genre)
            <h2>{{ $genre->name }}</h2>

            <!-- Películas -->
            @if(isset($movies) && count($movies) > 0)
                @foreach($movies as $movie)
                    @if($movie->genre_id == $genre->id)
                        <a href="{{ route('movies.show', $movie) }}">
                            <div class="movie">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="header">{{ $movie->title }}</div>
                                    <div class="">
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
                                            <button id="quitar" type="submit"
                                                style="border: none; background: none; padding: 0; font-size: inherit;  margin-right: 10px; margin: 5px;">
                                                <i class="{{ $isFavorite ? 'fa-solid' : 'fa-regular ' }} fa-star"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @foreach ($files as $file)
                                    @if($file->id == $movie->cover_id)
                                        <img alt="Portada Pelicula" src='{{ asset("storage/{$file->filepath}") }}' />
                                    @endif
                                @endforeach
                            </div>
                        </a>
                    @endif
                @endforeach
            @endif

            <!-- Series -->
            @if(isset($series) && count($series) > 0)
                @foreach($series as $serie)
                    @if($serie->genre_id == $genre->id)
                        <a href="{{ route('series.show', $serie) }}">
                            <div class="movie">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="header">{{ $serie->title }}</div>
                                    <div class="">
                                        @php
                                            $isFavorite = Auth::user()->favorited->contains('id', $serie->id);
                                        @endphp
                                        <form method="post" style="display: inline-block;"
                                            action="{{ $isFavorite ? route('series.unfavorite', $serie) : route('series.favorite', $serie) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @if($isFavorite)
                                                @method('DELETE')
                                            @endif
                                            <button id="quitar" type="submit"
                                                style="border: none; background: none; padding: 0; font-size: inherit;  margin-right: 10px; margin: 5px;">
                                                <i class="{{ $isFavorite ? 'fa-solid' : 'fa-regular ' }} fa-star"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @foreach ($files as $file)
                                    @if($file->id == $serie->cover_id)
                                        <img alt="Portada Pelicula" src='{{ asset("storage/{$file->filepath}") }}' />
                                    @endif
                                @endforeach
                            </div>
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
</div>
@endrole

@endsection
