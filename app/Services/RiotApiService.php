<?php

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

    public function getChampionDataAndNames()
    {
        $version = '13.22.1';
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/data/en_US/champion.json";
    
        $response = Http::get($url);
    
        $championData = $response->json();
        $championNames = collect($championData['data'])->pluck('name', 'key')->all();
    
        return compact('championData', 'championNames');
    }
    
    public function getChampionMasteriesBySummonerName($summonerName, $count = 3)
    {
        $summonerInfo = $this->getSummonerInfoByName($summonerName);
        if (isset($summonerInfo['puuid'])) {
            $endpoint = "/lol/champion-mastery/v4/champion-masteries/by-puuid/{$summonerInfo['puuid']}/top";
            $url = "{$this->apiBaseUrl}{$endpoint}?count={$count}&api_key={$this->riotApiKey}";

            $response = Http::get($url);
    
            return $response->json();
        }
    
        return null; 
    }

    public function getProfileIconUrl($profileIconId)
    {
        $version = '13.22.1'; 
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/img/profileicon/{$profileIconId}.png";
    
        return $url;
    }
}
