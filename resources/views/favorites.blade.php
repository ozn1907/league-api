@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full p-6 bg-white dark:bg-gray-800 rounded-md shadow-md">

        <h1 class="text-4xl font-extrabold mb-6 text-center text-indigo-600">Favorites</h1>

        @if($favorites->count() > 0)
        <ul class="space-y-4">
            @foreach($favorites as $favorite)
            <li class="flex items-center justify-between border-b border-gray-300 pb-2">
                <a href="{{ route('summoner.search', ['summonerName' => $favorite->favorite_name]) }}"
                    class="text-indigo-600 hover:underline">
                    {{ $favorite->favorite_name }}
                </a>
                <form action="{{ route('favorites.destroy', $favorite->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-red-500 duration-300 hover:text-red-700">
                        <x-typ-delete class="h-6 w-6" />
                    </button>
                </form>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-center text-gray-600">No favorites yet.</p>
        @endif

        <div class="fixed bottom-0 right-0 p-6">
            @if(session('success'))
            <x-alert type="success" :message="session('success')" />
            @elseif(session('info'))
            <x-alert type="info" :message="session('info')" />
            @elseif($errors->any())
            <x-alert type="error" :message="$errors->first()" />
            @endif
        </div>
    </div>
</div>
@endsection