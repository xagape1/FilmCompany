@extends('layouts.layoutMaster')

@section('title', 'Favoritos')

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

<script>
    let selectedPlan = null;

    function selectPlan(plan) {
        selectedPlan = plan;
        updatePlanStyles();
    }

    function updatePlanStyles() {
        const planOptions = document.querySelectorAll('.plan-option');
        planOptions.forEach(option => {
            const plan = option.innerText.toLowerCase();
            if (plan === selectedPlan) {
                option.style.backgroundColor = '#3498db';
                option.style.color = '#fff';
            } else {
                option.style.backgroundColor = '';
                option.style.color = '';
            }
        });
    }

    function subscribe() {
        if (selectedPlan) {
            alert(`Subscribed to ${selectedPlan} plan!`);
            route("subscribe");
        } else {
            alert('Please select a subscription plan.');
        }
    }
</script>

@endrole
@role('admin|pay')

<div class="card">
    <div class="header">
        <h1 class="title">FAVORITES</h1>
    </div>

    @if(count($favoriteMovies) > 0)
    <div class="header">
        <h1 class="title">FAVORITES MOVIES</h1>
    </div>
    <ul class="movie-list">
        @foreach ($favoriteMovies as $favoriteMovie)
        <li class="movie-item">
            <a href="{{ route('movies.show', $favoriteMovie->id) }}">
                <div class="movie">
                    <div class="header">{{ $favoriteMovie->title }}</div>
                    @foreach ($data['files'] as $file)
                    @if($file->id == $favoriteMovie->cover_id)
                    <img class="cover-image" alt="Portada Película" src='{{ asset("storage/{$file->filepath}") }}' />
                    @endif
                    @endforeach
                    <form method="post" class="favorite-form" action="{{ route('movies.unfavorite', $favoriteMovie) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="removef">
                            <button type="submit" class="favorite-button">
                                <i class="fa-solid fa-star"></i> Remove Favorite
                            </button>
                        </div>
                    </form>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($favoriteSeries) > 0)
    <div class="header">
        <h1 class="title">FAVORITES SERIES</h1>
    </div>
    <ul class="movie-list">
        @foreach ($favoriteSeries as $favoriteSerie)
        <li class="movie-item">
            <a href="{{ route('series.show', $favoriteSerie->id) }}">
                <div class="movie">
                    <div class="header">{{ $favoriteSerie->title }}</div>
                    @foreach ($data['files'] as $file)
                    @if($file->id == $favoriteSerie->cover_id)
                    <img class="cover-image" alt="Portada Película" src='{{ asset("storage/{$file->filepath}") }}' />
                    @endif
                    @endforeach
                    <form method="post" class="favorite-form" action="{{ route('series.unfavorite', $favoriteSerie) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="removef">
                            <button type="submit" class="favorite-button">
                                <i class="fa-solid fa-star"></i> Remove Favorite
                            </button>
                        </div>
                    </form>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($favoriteEpisodes) > 0)
    <div class="header">
        <h1 class="title">FAVORITES EPISODES</h1>
    </div>
    <ul class="movie-list">
        @foreach ($favoriteEpisodes as $favoriteEpisode)
        <li class="movie-item">
            <a href="{{ route('episodes.show', $favoriteEpisode->id) }}">
                <div class="movie">
                    <div class="header">{{ $favoriteEpisode->title }}</div>
                    @foreach ($data['files'] as $file)
                    @if($file->id == $favoriteEpisode->cover_id)
                    <img class="cover-image" alt="Portada Película" src='{{ asset("storage/{$file->filepath}") }}' />
                    @endif
                    @endforeach
                    <form method="post" class="favorite-form" action="{{ route('episodes.unfavorite', $favoriteEpisode) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="removef">
                            <button type="submit" class="favorite-button">
                                <i class="fa-solid fa-star"></i> Remove Favorite
                            </button>
                        </div>
                    </form>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($favoriteMovies) <= 0 && count($favoriteSeries) <=0 && count($favoriteEpisodes) <=0) <p class="no-favorites">No favorite items found.</p>
        @endif
</div>

@endrole

<style>
    .removef {
        padding: 2px;
    }

    body {
        font-family: 'Nunito', sans-serif;
        margin: 0;
        padding: 0;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .title {
        text-align: center;
    }

    .no-favorites {
        text-align: center;
    }

    .movie-list {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background-color: transparent;
        overflow: visible;
        list-style: none;
        max-width: 100%;

    }

    .movie {
        border: 2px solid transparent;
        border-radius: 8px;
        text-align: center;
        transition: box-shadow 0.3s;
        max-width: 100%;
    }

    .movie:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .header {
        font-size: 21px;
        font-weight: bold;
    }

    .cover-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .favorite-form {
        display: inline-block;
    }

    .favorite-button {
        border: none;
        background: none;
        padding: 0;
        font-size: inherit;
        cursor: pointer;
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

@endsection