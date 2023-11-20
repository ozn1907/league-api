@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full p-6 bg-white dark:bg-gray-800 rounded-md shadow-md relative">

        <h1 class="text-4xl font-extrabold mb-6 text-center text-indigo-600">Favorites</h1>

        @if($favorites->count() > 0)
        <ul>
            @foreach($favorites as $favorite)
            <li>{{ $favorite->favorite_name }}</li>
            @endforeach
        </ul>
        @else
        <p class="text-center text-gray-600">No favorites yet.</p>
        @endif
    </div>

    <div class="fixed bottom-0 right-0 p-6">
        @if(session('success') || session('info') || $errors->any())
        @if(session('success'))
        <x-alert type="success" :message="session('success')" />
        @elseif(session('info'))
        <x-alert type="info" :message="session('info')" />
        @elseif($errors->any())
        <x-alert type="error" :message="$errors->first()" />
        @endif
        @endif
    </div>

</div>
@endsection