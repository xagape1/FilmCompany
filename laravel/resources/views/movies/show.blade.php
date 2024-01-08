<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('box-title')
{{ __('movies') . " " . $movie->id }}
@endsection

@section('content')
<div class="card">
    <table class="tableshowtexto">
        <tr>
            <td class="titlemovie"><strong>{{ $movie->title }}</strong></td>
        </tr>

        </tbody>
    </table>
    <table>
        @foreach ($files as $file)
        @if($file->id == $movie->intro_id)
        <div>
            <video class="showvideo" controls>
                <source alt="Pelicula" type="video/mp4" src='{{ asset("storage/{$file->filepath}") }}' />
            </video>
        </div>
        @endif
        @endforeach
        </tbody>
    </table>

    <div class="card synopsis">
        <div>
            <table class="tableshowsynopsis">
                <tr>
                    <td class="synopsis">{{ $movie->description }}</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card ">
                    <div class="card-header ">
                        <h1 class="text-center h2 fw-bold">Añadir Valoración</h1>
                    </div>
                    <form method="post" class="separar"
                        action="{{ route('movies.reviews.store', ['movie' => $movie]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="linea-inferior text-center fw-bold">Valoraciones</h1>
                        @foreach ($reviews as $review)
                        <div class="row linea-inferior">
                            <div class="border col-md-8">
                                <td> {{ $review->user->name }}</td>
                                <br>
                                {{ $review->description }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @role('admin')
    <div class="showtexto">
        <!-- Buttons -->
        <div class="container" style="margin-bottom:20px">
            <a class="btn btn-warning" href="{{ route('movies.edit', $movie) }}" role="button">📝 {{ __('Edit')
                }}</a>
            <form id="form" method="POST" action="{{ route('movies.destroy', $movie) }}" style="display: inline-block;">
                @csrf
                @method("DELETE")
                <button id="destroy" type="submit" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#confirmModal">🗑️ {{ __('Delete') }}</button>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Are you sure?') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('You are gonna delete movie ') . $movie->id }}</p>
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
    @endsection