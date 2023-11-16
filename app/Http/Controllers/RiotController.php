<?php

namespace App\Http\Controllers;

use App\Services\RiotApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use App\Services\PaginationService;

class RiotController extends Controller
{
    protected $riotApiService;

    public function __construct(RiotApiService $riotApiService)
    {
        $this->middleware('auth');
        $this->riotApiService = $riotApiService;
    }

    public function searchSummoner(Request $request)
    {
        $summonerName = $request->input('summonerName');
        $summonerInfo = $this->riotApiService->getSummonerInfoByName($summonerName);

        return view('summoner-profile', compact('summonerInfo'));
    }

    public function rotation()
    {
        $freeRotation = $this->riotApiService->rotation();
        $championData = $this->riotApiService->getChampionData();
    
        $perPage = 8;
        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        
        $freeChampionIds = collect($freeRotation['freeChampionIds']);

        $freeRotation['freeChampionIds'] = PaginationService::paginateCollection($freeChampionIds, $perPage, $currentPage); // 
        
        return view('rotation', compact('freeRotation', 'championData'));
    }
}    