<head>
    <link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>

@extends('layouts/layoutMaster')

@section('box-title')

{{ __('series') . " " . $serie->id }}

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

<div class="content-container">
    <table class="tableshowtexto">
        <tr>
            <td>
                <h1 class="text h2 fw-bold">{{ $serie->title }}</h1>
            </td>
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

    <label for="season_id" class="custom-label">{{ __('Select Season') }}</label>
    <div class="season-links d-flex flex-wrap">
        @foreach ($serie->seasons as $season)
        <div>
            <a href="{{ route('series.seasons.show', ['serie' => $serie, 'season' => $season]) }}" class="btn btn-light btn-season">{{ $season->title }}</a>

            @role('admin')
            <a href="{{ route('seasons.edit', ['season' => $season]) }}" class="btn btn-secondary btn-edit" role="button">📝 {{ __('Edit') }}</a>

            <form id="form-{{ $season->id }}" method="POST" action="{{ route('seasons.destroy', ['season' => $season]) }}" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $season->id }}">🗑️ {{ __('Delete') }}</button>
            </form>

            @endrole
        </div>
        @endforeach
    </div>
</div>


<script>
    function confirmDelete(formId) {
        $('#confirmModal-' + formId).modal('hide');

        $('#' + formId).submit();
    }
</script>


@role('admin')
<form method="post" class="separar" action="{{ route('seasons.store', ['serie' => $serie]) }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group"> <label for="title">{{ __('Add Season') }}</label> <textarea id="title" name="title" class="form-control"></textarea>
        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
    </div>
</form>

@endrole
<table class="custom-synopsis">
    <tr>
        <td class="ESPACIO">{{ $serie->description }}</td>
    </tr>
</table>
@endrole

@endsection

<style>
    body {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Nunito', sans-serif;
    }

    .custom-label {
        display: block;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
        margin-top: 10px;
    }

    .custom-synopsis {
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        width: 100%;
        box-sizing: border-box;
    }

    .ESPACIO {
        padding: 1vh;
    }

    .content-container {
        @foreach ($files as $file) @if($file->id ==$serie->cover_id) background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.8)), url('{{ asset("storage/{$file->filepath}") }}');
        @endif @endforeach background-size: cover;
        /* Cambié a cover para cubrir completamente el fondo */
        background-position: center;
        background-repeat: no-repeat;
        padding: 25vh;
        font-family: 'Nunito', sans-serif;
    }

    .tableshowtexto {
        margin-top: -23vh;
        margin-left: -23vh;
    }

    .tableshowtexto h1 {
        font-size: 4rem;
        margin-bottom: 0;
    }

    .synopsis {
        margin-top: 20px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.4);
        border-top-left-radius: 5px;
        border-top-right-radius: 15px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 20px;
    }

    .modal-content {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

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