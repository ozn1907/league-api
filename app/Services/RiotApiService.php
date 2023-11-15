<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RiotApiService
{
    protected $riotApiKey;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->riotApiKey = config('app.riot_api_key');
        $this->apiBaseUrl = 'https://euw1.api.riotgames.com';
    }

    public function getSummonerInfoByName($summonerName)
    {
        $endpoint = "/lol/summoner/v4/summoners/by-name/{$summonerName}";
        $url = "{$this->apiBaseUrl}{$endpoint}?api_key={$this->riotApiKey}";

        $response = Http::get($url);

        return $response->json();
    }
}