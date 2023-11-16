<?php

namespace App\Http\Controllers;

use App\Services\RiotApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Services\PaginationService;

class RiotController extends Controller
{
    protected $riotApiService;
    

    public function __construct(RiotApiService $riotApiService)
    {
        $this->middleware('auth');
        $this->riotApiService = $riotApiService;
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
