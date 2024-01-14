<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('Add Serie') }}
@endsection

@section('content')
<div class="containercreate">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="border posts">
                    <form method="post" action="{{ route('series.store') }}" enctype="multipart/form-data"> @csrf
                        <div class="form-group"> <label for="title">{{ __('TITLE') }}</label> <textarea id="title"
                                name="title" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('SYNOSPYS') }}</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="genre_id">{{ __('GENRE') }}</label>
                            <select id="genre_id" name="genre_id" class="form-control">
                                @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover">{{ __('COVER') }}</label>
                            <input type="file" id="cover" name="cover" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection