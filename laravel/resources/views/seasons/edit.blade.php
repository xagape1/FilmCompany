<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('seasons') . " " . $season->id }}

@endsection

@role('admin')

@section('content')

@section('box-title')

{{ __('seasons') . " " . $season->id }}

@endsection

<form method="POST" action="{{ route('seasons.update', $season) }}" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="form-group">
        <label for="title">Name Season</label>
        <textarea id="title" name="title" class="form-control">{{ $season->title }}</textarea>
    </div>
    <div class="form-group">
        <label for="serie_id">Serie ID</label>
        <input type="text" id="serie_id" name="serie_id" class="form-control" value="{{ $season->serie_id }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="reset" class="btn btn-secondary">Reset</button>
</form>


@endrole
@endsection