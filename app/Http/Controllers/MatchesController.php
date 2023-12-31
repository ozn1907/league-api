<?php

namespace App\Http\Controllers;

use App\Services\RiotApiService;

class MatchesController extends Controller
{
    protected $riotApiService;

    public function __construct(RiotApiService $riotApiService)
    {
        $this->riotApiService = $riotApiService;
    }

    
    public function getMatchIdsBySummonerName(string $summonerName, int $start = 0, int $count = 100)
    {
        $summonerInfo = $this->riotApiService->getSummonerInfoByName($summonerName);

        if ($summonerInfo && isset($summonerInfo['puuid'])) {
            return $this->riotApiService->getMatchIdsByPuuid($summonerInfo['puuid'], $start, $count);
        }

        return null;
    }
}