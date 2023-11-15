<?php
// app/Services/RiotApiService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RiotApiService
{
    protected $riotApiKey;
    protected $apiBaseUrl;
    protected $dataDragonBaseUrl;

    public function __construct()
    {
        $this->riotApiKey = config('app.riot_api_key');
        $this->apiBaseUrl = 'https://euw1.api.riotgames.com';
        $this->dataDragonBaseUrl = 'https://ddragon.leagueoflegends.com';
    }

    public function getSummonerInfoByName($summonerName)
    {
        $endpoint = "/lol/summoner/v4/summoners/by-name/{$summonerName}";
        $url = "{$this->apiBaseUrl}{$endpoint}?api_key={$this->riotApiKey}";

        $response = Http::get($url);

        return $response->json();
    }

    public function rotation()
    {
        $endpoint = "/lol/platform/v3/champion-rotations";
        $url = "{$this->apiBaseUrl}{$endpoint}?api_key={$this->riotApiKey}";

        $response = Http::get($url);

        return $response->json();
    }

    public function getChampionData()
    {
        $version = '13.22.1';
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/data/en_US/champion.json";

        $response = Http::get($url);

        return $response->json();
    }

}
