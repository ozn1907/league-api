@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-5xl w-full p-6 bg-white dark:bg-gray-800 rounded-md shadow-md">
        @if(isset($summonerInfo) && isset($summonerInfo['name']) && isset($summonerInfo['summonerLevel']))
        <form action="{{ route('favorites') }}" method="post" class="mb-6 text-center">
            @csrf
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <img src="{{ $dataDragonService->getProfileIconUrl($summonerInfo['profileIconId']) }}"
                        alt="Profile Icon" class="w-32 h-32 rounded-full shadow-md border-4">
                    <div class="ml-4">
                        <p class="text-gray-800 text-lg font-semibold text-left">{{ $summonerInfo['name'] }}</p>
                        <p class="text-gray-600">Summoner Level: {{ $summonerInfo['summonerLevel'] }}</p>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="favoriteName" value="{{ $summonerInfo['name'] }}">
                    <button type="submit">
                        <x-fas-star class="h-6 w-6 duration-300 text-black hover:text-yellow-500 vibrate" />
                    </button>
                </div>
            </div>
        </form>
        @else
        <p class="text-center text-red-500 font-bold">Summoner does not exist.</p>
        @endif
        @if(isset($championMasteries))
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Champion Masteries</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($championMasteries as $key => $mastery)
                <div class="relative">
                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-300 p-6 rounded-md hover:border-indigo-500 hover:shadow-lg hover:transform hover:scale-105 transition duration-300">
                        <img src="{{ $dataDragonService->getChampionIconUrl(optional($mastery)['championId']) }}"
                            alt="Champion Icon" class="w-20 h-20 mx-auto mb-4 rounded-full">
                        <p class="font-semibold text-lg text-indigo-800">
                            {{ $championNames[optional($mastery)['championId']] }}</p>
                        <p class="text-gray-600 flex justify-center items-center">
                            Mastery Level: {{ optional($mastery)['championLevel'] }}
                            <img class="h-4 w-4 inline-block ml-1" src="{{ asset('svg/mastery_crown.svg') }}"
                                alt="Mastery Crown Icon">
                        </p>
                        <p class="text-gray-600">Champion Points: <span class="font-semibold">{{
                                optional($mastery)['championPoints'] }}</span></p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection