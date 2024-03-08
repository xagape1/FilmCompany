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
            <h1 class="text h2 fw-bold">{{ $movie->title }}</strong></h1>
        </tr>

        </tbody>
    </table>
    <table>
        @foreach ($files as $file)
        @if($file->id == $movie->intro_id)
        <div>
            <video class="showvideo" id="myVideo" controls>
                <source alt="Pelicula" type="video/mp4" src='{{ asset("storage/{$file->filepath}") }}' />
                <source alt="Pelicula" type="video/webm" src='{{ asset("storage/{$file->filepath}") }}' />
                Tu navegador no soporta el tag de video.
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

    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card ">
                <h1 class="text-center h2 fw-bold">Write your Review</h1>
                <form method="post" class="separar" action="{{ route('movies.reviews.store', ['movie' => $movie]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Add Review') }}</button>
                    <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="linea-inferior text-center fw-bold">Reviews</h1>
                @if(count($reviews) > 0)
                @foreach ($reviews as $review)
                <div class="row linea-inferior">
                    <div class="card border col-md-8">
                        <div class="d-flex flex-column justify-content-between align-items-start">
                            <div>
                                <p><strong>{{ $review->user->name }}</strong></p>
                                <p style="overflow-y: auto; max-height: 200px;">{{ $review->description }}</p>
                            </div>
                            @if(auth()->user()->hasRole('admin') || $review->author_id == $id)
                            <form id="form" method="POST" action="{{ route('movies.reviews.destroy', [$movie, $review]) }}" style="display: inline-block;">
                                @csrf
                                @method("DELETE")
                                <button id="destroy" type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">🗑️ {{ __('Delete Review') }}</button>
                            </form>
                            @endif
                            <div>
                                <div>
                                    <td><strong>{{ __('Created') }}</strong></td>
                                    <td>{{ $review->created_at }}</td>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <p>There are no reviews, write your opinion about the movie!!</p>
                @endif
            </div>
        </div>
    </div>


    @role('admin')
    <div class="showtexto">
        <a class="btn btn-secondary" href="{{ route('movies.edit', $movie) }}" role="button">📝 {{ __('Edit Movie')
            }}</a>
        <form id="form" method="POST" action="{{ route('movies.destroy', $movie) }}" style="display: inline-block;">
            @csrf
            @method("DELETE")
            <button id="destroy" type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">🗑️ {{ __('Delete Movie') }}</button>
        </form>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var video = document.querySelector('.showvideo');

            video.addEventListener('loadedmetadata', function() {
                // Metadatos cargados, puedes realizar acciones aquí
            });
        });
    </script>