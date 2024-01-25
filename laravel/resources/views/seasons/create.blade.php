<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('Add Season') }}
@endsection

@section('content')
<div class="containercreate">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="border posts">
                    <a href="{{ route('seasons.store', ['serie' => $serie->id]) }}" class="btn btn-primary">
                        Add Season
                    </a>
                    <div class="form-group"> <label for="title">{{ __('Title') }}</label> <textarea id="title" name="title" class="form-control"></textarea>
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