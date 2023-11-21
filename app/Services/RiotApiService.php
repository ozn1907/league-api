<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Config;

class RiotApiService
{
    protected $riotApiKey;
    protected $apiBaseUrl;
    protected $dataDragonBaseUrl;
    protected $defaultVersion;

    public function __construct()
    {
        $this->riotApiKey = config('app.riot_api_key');
        $this->apiBaseUrl = config('app.api_base_url');
        $this->dataDragonBaseUrl = config('app.data_dragon_base_url');
        $this->defaultVersion = config('app.default_version');
    }

    protected function buildApiUrl($endpoint, $queryParams = [])
    {
        $url = "{$this->apiBaseUrl}{$endpoint}?api_key={$this->riotApiKey}";

        if (!empty($queryParams)) {
            $url .= '&' . http_build_query($queryParams);
        }

        return $url;
    }

    public function getSummonerInfoByName($summonerName)
    {
        $endpoint = "/lol/summoner/v4/summoners/by-name/{$summonerName}";
        $url = $this->buildApiUrl($endpoint);

        $response = Http::get($url);

        return $response->json();
    }

    public function rotation()
    {
        $endpoint = "/lol/platform/v3/champion-rotations";
        $url = $this->buildApiUrl($endpoint);

        $response = Http::get($url);

        return $response->json();
    }

    public function getChampionDataAndNames($version = null)
    {
        $version = $version ?: $this->defaultVersion;
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/data/en_US/champion.json";

        $response = Http::get($url);

        $championData = $response->json();

        $championNames = collect($championData['data'])->pluck('name', 'key')->all();
        return compact('championData', 'championNames');
    }

    public function getChampionMasteriesBySummonerName($summonerName, $count = 4)
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

    public function getProfileIconUrl($profileIconId, $version = null)
    {
        $version = $version ?: $this->defaultVersion;
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/img/profileicon/{$profileIconId}.png";

        return $url;
    }

    public function getChampionIconUrl($championId, $version = null)
    {
        $version = $version ?: $this->defaultVersion;
        $championData = $this->getChampionData($version);

        // Find the champion by key
        $champion = collect($championData)->firstWhere('key', $championId);

        // Use the first matching champion (if any)
        if ($champion) {
            $championName = $champion['name'];

            // Check if the name contains an apostrophe
            $championNameInUrl = strpos($championName, "'") !== false
                ? ucfirst(strtolower(str_replace(['\'', ' '], ['', ''], $championName)))
                : str_replace(' ', '', $championName);

            // Construct the URL with the champion name
            return "{$this->dataDragonBaseUrl}/cdn/{$version}/img/champion/{$championNameInUrl}.png";
        }

        // Construct the URL with the champion ID if the name is not found
        return "{$this->dataDragonBaseUrl}/cdn/{$version}/img/champion/{$championId}.png";
    }

    protected function getChampionData($version)
    {
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/data/en_US/champion.json";
        $response = Http::get($url);

        return $response->json()['data'];
    }
}
