<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('series') . " " . $serie->id }}
@endsection

@role('admin')

@section('content')
<div class="containeredit">
    <div class="row justify-content-center espacioedit">
        @foreach ($files as $file)
        @if($file->id == $serie->cover_id)
        <div class="col-md-6">
            <img class="img-posts-show" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview" />
        </div>
        @endif
        @endforeach
    </div>

    <div class="col-md-8">
        <div class="card">
            <form method="POST" action="{{ route('series.update', $serie) }}" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="title">TITLE</label>
                    <textarea id="title" name="title" class="form-control">{{ $serie->title }}</textarea>
                </div>
                <div class="form-group">
                    <label for="description">SYNOPSYS </label>
                    <textarea id="description" name="description" class="form-control">{{ $serie->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="genre_id">{{ __('GENRE') }}</label>
                    <select id="genre_id" name="genre_id" class="form-control">
                        @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" @if($genre->id == $serie->genre_id) selected @endif>{{
                            $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="cover">COVER</label>
                    <input type="file" id="cover" name="cover" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>
</div>
@endrole
@endsection