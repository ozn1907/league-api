<?php

namespace App\Http\Controllers;

use App\Services\RiotApiService;
use Illuminate\Support\Facades\Log;
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

        if (!$summonerInfo || !isset($summonerInfo['puuid'])) {
            return null;
        }

        try {
            return $this->riotApiService->getMatchIdsByPuuid($summonerInfo['puuid'], $start, $count);
        } catch (\Exception $e) {
            Log::error("Exception in getMatchIdsBySummonerName: {$e->getMessage()}");
            return null;
        }
    }
}