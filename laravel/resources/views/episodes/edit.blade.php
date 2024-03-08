<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('episodes') . " " . $episode->id }}
@endsection

@section('content')
<div class="containeredit">
    <div class="row justify-content-center espacioedit">
        @foreach ($files as $file)
        @if($file->id == $episode->cover_id)
        <div class="col-md-6">
            <img class="img-posts-show" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview" />
        </div>
        @endif
        @endforeach

        @foreach ($files as $file)
        @if($file->id == $episode->intro_id)
        <div class="col-md-6">
            <video class="showvideo" controls>
                <source alt="Episodio" type="video/mp4" src='{{ asset("storage/{$file->filepath}") }}' />
            </video>
        </div>
        @endif
        @endforeach
    </div>

    <div class="col-md-8">
        <div class="card">
            <form method="POST" action="{{ route('episodes.update', $episode) }}" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="title">Title</label>
                    <textarea id="title" name="title" class="form-control">{{ $episode->title }}</textarea>
                </div>
                <div class="form-group">
                    <label for="description">Synopsys </label>
                    <textarea id="description" name="description" class="form-control">{{ $episode->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="cover">Cover</label>
                    <input type="file" id="cover" name="cover" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="intro">Episode</label>
                    <input type="file" id="intro" name="intro" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="season_id">{{ __('Season') }}</label>
                    <select id="season_id" name="season_id" class="form-control">
                        @foreach ($seasons as $season)
                        <option value="{{ $season->id }}">{{ $season->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>
</div>
@endsection