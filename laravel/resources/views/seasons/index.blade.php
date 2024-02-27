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
    <div class="form-group">
        <label for="season_id" class="custom-label">{{ __('Select Season') }}</label>
        <div class="season-links d-flex flex-wrap">
            @if($serie && $serie->season)
            @foreach ($serie->season as $season)
            <div class="season-item mx-2 my-2">
                <a href="{{ route('series.seasons.show', ['serie' => $serie, 'season' => $season]) }}" class="btn btn-light btn-season">{{ $season->title }}</a>

                @role('admin')
                <a href="{{ route('seasons.edit', ['season' => $season]) }}" class="btn btn-secondary btn-edit" role="button">📝 {{ __('Edit') }}</a>

                <form id="form-{{ $season->id }}" method="POST" action="{{ route('seasons.destroy', ['season' => $season]) }}" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $season->id }}">🗑️ {{ __('Delete') }}</button>
                </form>
                @endrole
            </div>
            @endforeach
            @else
            <p>No seasons available for this serie.</p>
            @endif
        </div>
    </div>
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