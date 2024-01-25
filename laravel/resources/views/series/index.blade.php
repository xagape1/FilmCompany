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
    @if(count($series) <= 0) <p>No se encontraron películas.</p>
        @else
        @foreach ($series as $serie)
        <a href="{{ route('series.show', $serie) }}">
            <div class="movie">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="header">{{ $serie->title }}</div>
                    <div class="">
                        @php
                        $isFavorite = Auth::user()->favoritedS->contains('id', $serie->id);
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
        @endforeach
        @endif
</div>

@endrole

@endsection