<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">


</head>

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('series') . " " . $serie->id }}
@endsection

@section('content')
<div class="content-container">
    <table class="tableshowtexto">
        <tr>
            <td>
                <h1 class="text h2 fw-bold">{{ $serie->title }}</h1>
            </td>
        </tr>
    </table>

    <table class="tableshowsynopsis">
        <tr>
            <td class="synopsis">{{ $serie->description }}</td>
        </tr>
    </table>
</div>
@role('admin')
<div class="showtexto">
    <a class="btn btn-secondary" href="{{ route('series.edit', $serie) }}" role="button">📝 {{ __('Edit Serie')
            }}</a>
    <form id="form" method="POST" action="{{ route('series.destroy', $serie) }}" style="display: inline-block;">
        @csrf
        @method("DELETE")
        <button id="destroy" type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">🗑️ {{ __('Delete Serie') }}</button>
    </form>
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Are you sure?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('You are gonna delete serie ') . $serie->id }}</p>
                    <p>{{ __('This action cannot be undone!') }}</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="confirm" type="button" class="btn btn-primary">{{ __('Confirm')
                                }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole

<div class="form-group">
    <label for="season_id">{{ __('Select Season') }}</label>
    <div class="season-links">
        @foreach ($serie->seasons as $season)
        <a href="{{ route('seasons.show', ['season' => $season]) }}">{{ $season -> title}}</a>

        @endforeach

    </div>
</div>


@role('admin')
<form method="post" class="separar" action="{{ route('series.seasons.store', ['serie' => $serie]) }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group"> <label for="title">{{ __('Add Season') }}</label> <textarea id="title" name="title" class="form-control"></textarea>
        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
    </div>
</form>
@endrole
@endsection

<style>
    body {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Nunito', sans-serif;
    }

    .content-container {
        @foreach ($files as $file) @if($file->id ==$serie->cover_id) background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.8)), url('{{ asset("storage/{$file->filepath}") }}');
        @endif @endforeach background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 10vh;
        font-family: 'Nunito', sans-serif;
    }

    .synopsis {
        margin-top: 20px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.4);
        border-top-left-radius: 5px;
        border-top-right-radius: 15px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 20px;
        color: #000;
    }

    .modal-content {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>