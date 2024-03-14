@extends('layouts/layoutMaster')

@section('title', 'Home')

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
<div class="genre-container">
    @if(count($genres) <= 0) <p>No se encontraron géneros.</p>
        @else
        @php
        $hasContent = false;
        @endphp

        @foreach ($genres as $genre)
        @php
        $moviesInGenre = $movies->where('genre_id', $genre->id);
        $seriesInGenre = $series->where('genre_id', $genre->id);
        $hasMoviesInGenre = $moviesInGenre->isNotEmpty();
        $hasSeriesInGenre = $seriesInGenre->isNotEmpty();
        $hasContentInGenre = $hasMoviesInGenre || $hasSeriesInGenre;
        $hasContent = $hasContent || $hasContentInGenre;
        @endphp

        @if ($hasContentInGenre)
        <section class="genre-section">
            <h2>{{ $genre->name }}</h2>
            <!-- Películas -->
            @if ($hasMoviesInGenre)
            <div class="movie-container">
                @foreach ($moviesInGenre as $movie)
                <a href="{{ route('movies.show', $movie) }}" class="movie-link">
                    <div class="movie">
                        <div class="movie-header">
                            <div class="movie-title">{{ $movie->title }}</div>
                            <div class="movie-actions">
                                @php
                                $isFavorite = Auth::user()->favoritedM->contains('id', $movie->id);
                                @endphp
                                <form method="post" class="favorite-form" action="{{ $isFavorite ? route('movies.unfavorite', $movie) : route('movies.favorite', $movie) }}" enctype="multipart/form-data">
                                    @csrf
                                    @if($isFavorite)
                                    @method('DELETE')
                                    @endif
                                    <button type="submit" class="favorite-button">
                                        <i class="{{ $isFavorite ? 'fa-solid' : 'fa-regular ' }} fa-star"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @foreach ($files as $file)
                        @if($file->id == $movie->cover_id)
                        <img alt="Portada Pelicula" src='{{ asset("storage/{$file->filepath}") }}' class="movie-cover" />
                        @endif
                        @endforeach
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            <!-- Series -->
            @if ($hasSeriesInGenre)
            <div class="series-container">
                @foreach ($seriesInGenre as $serie)
                <a href="{{ route('series.show', $serie) }}" class="movie-link">
                    <div class="movie">
                        <div class="movie-header">
                            <div class="movie-title">{{ $serie->title }}</div>
                            <div class="movie-actions">
                                @php
                                $isFavorite = Auth::user()->favoritedS->contains('id', $serie->id);
                                @endphp
                                <form method="post" class="favorite-form" action="{{ $isFavorite ? route('series.unfavorite', $serie) : route('series.favorite', $serie) }}" enctype="multipart/form-data">
                                    @csrf
                                    @if($isFavorite)
                                    @method('DELETE')
                                    @endif
                                    <button type="submit" class="favorite-button">
                                        <i class="{{ $isFavorite ? 'fa-solid' : 'fa-regular ' }} fa-star"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @foreach ($files as $file)
                        @if($file->id == $serie->cover_id)
                        <img alt="Portada Pelicula" src='{{ asset("storage/{$file->filepath}") }}' class="movie-cover" />
                        @endif
                        @endforeach
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </section>
        @endif
        @endforeach

        @if (!$hasContent)
        <p class="movie-title">No movies or series found, wait the maintenance.</p>
        @endif
        @endif
</div>

@endrole
@endsection

<style>
    .genre-container {
        margin: 20px;
    }

    .genre-section {
        margin-bottom: 30px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 20px;
    }

    .movie-container,
    .series-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
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

    .movie-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
    }

    .movie-title {
        font-size: 18px;
        font-weight: bold;
    }

    .favorite-form {
        display: inline-block;
    }

    .favorite-button {
        border: none;
        background: none;
        padding: 0;
        font-size: inherit;
        margin-right: 10px;
        margin: 5px;
        cursor: pointer;
    }

    .movie-cover {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
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