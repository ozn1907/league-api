<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Config;

class RiotApiService
{
    protected $riotApiKey;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->riotApiKey = config('app.riot_api_key');
        $this->apiBaseUrl = config('app.api_base_url');
    }

    protected function buildApiUrl($endpoint, $queryParams = [])
    {
        $url = "{$this->apiBaseUrl}{$endpoint}?api_key={$this->riotApiKey}";

        if (!empty($queryParams)) {
            $url .= '&' . http_build_query($queryParams);
        }

        return $url;
    }

    public function getSummonerInfoByName($summonerName): array
    {
        $endpoint = "/lol/summoner/v4/summoners/by-name/{$summonerName}";
        $url = $this->buildApiUrl($endpoint);

        $response = Http::get($url);

        return $response->json();
    }

    public function getChampionMasteriesBySummonerName($summonerName, $count = 3)
    {
        $summonerInfo = $this->getSummonerInfoByName($summonerName);

        if (optional($summonerInfo)['puuid']) {
            $endpoint = "/lol/champion-mastery/v4/champion-masteries/by-puuid/{$summonerInfo['puuid']}/top";
            $url = $this->buildApiUrl($endpoint, ['count' => $count]);

            $response = Http::get($url);

            return $response->json();
        }

        return null;
    }

    public function getMatchIdsByPuuid(string $puuid, int $start = 0, int $count = 100): ?array
    {
        $url = sprintf(
            'https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/%s/ids?start=%d&count=%d&api_key=%s',
            $puuid,
            $start,
            $count,
            $this->riotApiKey
        );

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("API Request failed: {$response->status()}");
        } catch (\Exception $e) {
            Log::error("Exception during API Request: {$e->getMessage()}");
        }

        return null;
    }

    public function getMatchDetailsById(string $matchId): ?array
    {
        $url = sprintf(
            'https://europe.api.riotgames.com/lol/match/v5/matches/%s?api_key=%s',
            $matchId,
            $this->riotApiKey
        );

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("API Request failed: {$response->status()}");
        } catch (\Exception $e) {
            Log::error("Exception during API Request: {$e->getMessage()}");
        }

        return null;
    }

    public function isSummonerWinner(array $matchDetails, string $summonerName): bool
    {
        foreach ($matchDetails['info']['participants'] as $participant) {
            if ($participant['summonerName'] === $summonerName) {
                $participantTeamId = $participant['teamId'];

                foreach ($matchDetails['info']['teams'] as $team) {
                    if ($team['teamId'] === $participantTeamId) {
                        return $team['win'];
                    }
                }
            }
        }

        return false;
    }

    public function getChampionList(): ?array
    {
        $endpoint = '/lol/static-data/v4/champions';
        $url = $this->buildApiUrl($endpoint);

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error("API Request failed: {$response->status()}");
        return null;
    }
}
