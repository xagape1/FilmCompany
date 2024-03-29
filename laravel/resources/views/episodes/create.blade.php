<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('Add Episode') }}
@endsection

@section('content')
<div class="containercreate">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="border posts">
                    <form method="post" action="{{ route('episodes.store') }}" enctype="multipart/form-data"> @csrf
                        <div class="form-group"> <label for="title">{{ __('Title') }}</label> <textarea id="title" name="title" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Synopsys') }}</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="cover">{{ __('Cover') }}</label>
                            <input type="file" id="cover" name="cover" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="intro">{{ __('Episode') }}</label>
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

                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection