@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">

    <div class="max-w-2xl w-full p-6 bg-white dark:bg-gray-800 rounded-md shadow-md">

        @isset($summonerInfo)
        <h1 class="text-4xl font-extrabold mb-6 text-center text-indigo-600">Summoner Profile</h1>
        <div class="mb-8 text-center">
            <img src="http://ddragon.leagueoflegends.com/cdn/11.11.1/img/profileicon/{{ $summonerInfo['profileIconId'] }}.png" alt="Profile Icon" class="inline-block rounded-full shadow-md border-4 border-indigo-300 p-2">
        </div>
        <div class="mb-6 text-center">
            <p class="text-gray-800 text-lg font-semibold">{{ $summonerInfo['name'] }}</p>
            <p class="text-gray-600">Summoner Level: {{ $summonerInfo['summonerLevel'] }}</p>
            <!-- Display other summoner information as needed -->
        </div>
        @else
        <p class="text-center text-gray-600">No summoner information available.</p>
        @endisset

    </div>

</div>

@endsection
