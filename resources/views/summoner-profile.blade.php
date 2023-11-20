@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full p-6 bg-white dark:bg-gray-800 rounded-md shadow-md">

        @if(isset($summonerInfo) && isset($summonerInfo['profileIconId']) && isset($summonerInfo['name']) && isset($summonerInfo['summonerLevel']))
            <h1 class="text-4xl font-extrabold mb-6 text-center text-indigo-600">Summoner Profile</h1>
            <div class="mb-8 text-center">
                <img src="{{ $riotApiService->getProfileIconUrl($summonerInfo['profileIconId']) }}" alt="Profile Icon" class="inline-block rounded-full shadow-md border-4 border-indigo-300 p-2">
            </div>
            
            <form action="{{ route('favorites') }}" method="post" class="mb-6 text-center">
                @csrf
                <input type="hidden" name="favoriteName" value="{{ $summonerInfo['name'] }}">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                    Add to Favorites
                </button>
            </form>
            
            <div class="mb-6 text-center">
                <p class="text-gray-800 text-lg font-semibold">{{ $summonerInfo['name'] }}</p>
                <p class="text-gray-600">Summoner Level: {{ $summonerInfo['summonerLevel'] }}</p>
            </div>
        @else
            <p class="text-center text-red-500 font-bold">Summoner does not exist.</p>
        @endif

        @if(isset($championMasteries))
            <div class="mb-6 text-center">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">Champion Masteries</h2>
                <div class="flex flex-wrap justify-center">
                    @foreach($championMasteries as $mastery)
                        <div class="m-4 p-4 border border-gray-300 rounded-md bg-indigo-100 text-indigo-800">
                            <p class="font-semibold">{{ $championNames[optional($mastery)['championId']] }}</p>
                            <p class="text-gray-600">Mastery Level: {{ optional($mastery)['championLevel'] }}</p>
                            <p class="text-gray-600">Champion Points: {{ optional($mastery)['championPoints'] }}</p> 
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
