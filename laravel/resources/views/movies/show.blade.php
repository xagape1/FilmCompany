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

@role('new')

<div class="subscription-container">
    <div class="subscription-header">Choose a Subscription Plan</div>

    <div class="plan-selector">
        <div class="plan-option" onclick="selectPlan('basic')">
            <h4 class="header-plan1">Basic Plan</h4>
            <div class="plan-details">
                <p><strong>Price:</strong></p>
                <p>$9.99/month</p>
                <p><strong>Quality of Video and Audio:</strong></p>
                <p>Good</p>
                <p><strong>Resolution:</strong></p>
                <p>1080p (Full HD)</p>
                <p><strong>Compatible Devices:</strong></p>
                <p>All type Devices Compatible</p>
                <p><strong>Devices in Your Home:</strong></p>
                <p>2</p>
                <p><strong>Downloads on Devices:</strong></p>
                <p>2</p>
                <p><strong>Ads:</strong></p>
                <p>Only a few minutes per hour</p>
            </div>
        </div>
        <div class="plan-option" onclick="selectPlan('standard')">
            <h4 class="header-plan2">Standard Plan</h4>
            <p><strong>Price:</strong></p>
            <p>$19.99/3month</p>
            <p><strong>Quality of Video and Audio:</strong></p>
            <p>Good</p>
            <p><strong>Resolution:</strong></p>
            <p>1080p (Full HD)</p>
            <p><strong>Compatible Devices:</strong></p>
            <p>All type Devices Compatible</p>
            <p><strong>Devices in Your Home:</strong></p>
            <p>4</p>
            <p><strong>Downloads on Devices:</strong></p>
            <p>6</p>
            <p><strong>Ads:</strong></p>
            <p>Only a few minutes per hour</p>
        </div>
        <div class="plan-option" onclick="selectPlan('premium')">
            <h4 class="header-plan3">Premium Plan</h4>
            <p><strong>Price:</strong></p>
            <p>$79.99/year</p>
            <p><strong>Quality of Video and Audio:</strong></p>
            <p>Excepional</p>
            <p><strong>Resolution:</strong></p>
            <p>4k (Ultra HD) + HDR</p>
            <p><strong>Compatible Devices:</strong></p>
            <p>All type Devices Compatible</p>
            <p><strong>Devices in Your Home:</strong></p>
            <p>4</p>
            <p><strong>Downloads on Devices:</strong></p>
            <p>6</p>
            <p><strong>Ads:</strong></p>
            <p>No have adds</p>
        </div>
    </div>

    <form method="POST" action="{{ route('handleSubscription') }}">
        @csrf
        <button type="submit" name="subscribeButton">Subscribe</button>
    </form>
</div>
@endrole

@role('admin|pay')
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
    @endrole
    @endsection
</div>


<style>
    .subscription-container {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        width: 100%;
        text-align: center;
        margin: auto;
    }

    .subscription-header {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .header-plan1 {
        margin: 0;
        background: linear-gradient(to right, #0055FF, #DC170B);
        border-radius: 10px;
        padding: 3px;
        color: white;
    }

    .header-plan2 {
        margin: 0;
        background: linear-gradient(to right, #DC170B, #6C00FE);
        border-radius: 10px;
        padding: 3px;
        color: white;
    }

    .header-plan3 {
        margin: 0;
        background: linear-gradient(to right, #6C00FE, #0055FF);
        border-radius: 10px;
        padding: 3px;
        color: white;
    }

    .plan-selector {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
        align-content: center;
        text-align: center;
    }

    .plan-option {
        flex: 1;
        padding: 20px;
        border: 2px solid #3498db;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .plan-option:hover {
        background-color: #3498db;
        color: #fff;
    }

    .subscribe-button {
        background-color: #3498db;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .subscribe-button:hover {
        background-color: #297fb8;
    }
</style>