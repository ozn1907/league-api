<?php

namespace App\Http\Controllers;

use App\Services\RiotApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Services\PaginationService;
use Illuminate\Support\Facades\Auth;
use App\Services\FavoriteService;

class RiotController extends Controller
{
    protected $riotApiService;
    protected $favoriteService;

    public function __construct(RiotApiService $riotApiService, FavoriteService $favoriteService)
    {
        $this->middleware('auth');
        $this->riotApiService = $riotApiService;
        $this->favoriteService = $favoriteService;
    }

    public function searchSummoner(Request $request, RiotApiService $riotApiService)
    {
        $summonerName = $request->input('summonerName');
        $summonerInfo = $this->riotApiService->getSummonerInfoByName($summonerName);
        $championMasteries = $this->riotApiService->getChampionMasteriesBySummonerName($summonerName);
        $combinedData = $this->riotApiService->getChampionDataAndNames();
        $championNames = $combinedData['championNames'];


        return view('summoner-profile', compact('summonerInfo', 'championMasteries', 'championNames', 'riotApiService'));
    }

    public function manageFavorites(Request $request)
    {
        $user = Auth::user();
    
        if ($request->has('favoriteName')) {
            $favoriteName = $request->input('favoriteName');
            $result = $this->favoriteService->addToFavorites($user, $favoriteName);
    
            return redirect()->route('favorites')->with($result['type'], $result['message']);
        }
    
        $favorites = $user->favorites;
    
        return view('favorites', compact('favorites'));
    }
    


    public function rotation()
    {
        $freeRotation = $this->riotApiService->rotation();
        $combinedData = $this->riotApiService->getChampionDataAndNames();
        $championData = $combinedData['championData'];

        $perPage = 8;
        $currentPage = Paginator::resolveCurrentPage() ?: 1;

        $freeChampionIds = collect($freeRotation['freeChampionIds']);
        $freeRotation['freeChampionIds'] = PaginationService::paginateCollection($freeChampionIds, $perPage, $currentPage);

        return view('rotation', compact('freeRotation', 'championData'));
    }
}
