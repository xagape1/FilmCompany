<!-- resources/views/search/index.blade.php -->

<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@extends('layouts/layoutMaster')

@section('title', 'Search Results')

@section('content')
    <div class="container">
        <h2>Search Results</h2>

        @if(count($results) > 0)
            @foreach($results as $result)
                <div class="search-result">
                    @if($result instanceof \App\Models\Movie)
                        <a href="{{ route('movies.show', $result) }}">
                            <div class="result-header">{{ $result->title }} (Movie)</div>
                        </a>
                    @elseif($result instanceof \App\Models\Serie)
                        <a href="{{ route('series.show', $result) }}">
                            <div class="result-header">{{ $result->title }} (Series)</div>
                        </a>
                    @elseif($result instanceof \App\Models\Episode)
                        <a href="{{ route('episodes.show', $result) }}">
                            <div class="result-header">{{ $result->title }} (Episode)</div>
                        </a>
                    @endif
                </div>
            @endforeach
        @else
            <p>No results found.</p>
        @endif
    </div>
@endsection
``
