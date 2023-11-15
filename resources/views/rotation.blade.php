@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5">
        @if(isset($freeRotation) && isset($championData))
            <h2 class="text-2xl font-black mb-4 text-center ">Free Champion Rotation</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($freeRotation['freeChampionIds'] as $championId)
                    @php
                        // Find the corresponding champion by ID
                        $champion = collect($championData['data'])->firstWhere('key', $championId);
                    @endphp

                    @if($champion)
                        <div class="bg-white rounded-lg overflow-hidden shadow-md mb-4">
                            {{-- <img src="{{ $dataDragonBaseUrl }}/cdn/{{ $version }}/img/champion/{{ $champion['image']['full'] }}" alt="{{ $champion['name'] }} Image" class="w-full h-32 object-cover"> --}}
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">{{ $champion['name'] }}</h3>
                                <p class="text-gray-600">{{ $champion['title'] }}</p>
                                <p class="text-gray-800 mt-2">{{ $champion['blurb'] }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-lg overflow-hidden shadow-md mb-4 p-4">
                            <p class="font-semibold mb-2 text-red-500">Champion with ID {{ $championId }} not found in champion data.</p>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Add more information as needed -->

        @else
            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4">
                <p class="text-xl font-semibold text-red-500">Free champion rotation information not available.</p>
            </div>
        @endif
    </div>
@endsection
