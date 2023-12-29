<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Config;

class RiotApiService
{
    /* The lines `protected ;` and `protected ;` are declaring two protected
    properties in the `RiotApiService` class. */
    protected $riotApiKey;
    protected $apiBaseUrl;

    /**
     * The function initializes the Riot API key and base URL by retrieving them from the application
     * configuration.
     */
    public function __construct()
    {
        $this->riotApiKey = config('app.riot_api_key');
        $this->apiBaseUrl = config('app.api_base_url');
    }

    /**
     * The function builds an API URL by concatenating the base URL, endpoint, and query parameters.
     * 
     * @param endpoint The endpoint parameter is a string that represents the specific API endpoint you
     * want to access. It is typically a URL path that comes after the base API URL.
     * @param queryParams An array of additional query parameters to be included in the API URL. These
     * parameters will be appended to the URL as key-value pairs.
     * 
     * @return the built API URL as a string.
     */
    protected function buildApiUrl($endpoint, $queryParams = [])
    {
        $url = "{$this->apiBaseUrl}{$endpoint}?api_key={$this->riotApiKey}";

        if (!empty($queryParams)) {
            $url .= '&' . http_build_query($queryParams);
        }

        return $url;
    }

    /**
     * The function retrieves summoner information by summoner name using the League of Legends API.
     * 
     * @param summonerName The summonerName parameter is the name of the summoner for which you want to
     * retrieve information. It is a string value that represents the in-game name of the summoner.
     * 
     * @return the JSON response from the API call.
     */
    public function getSummonerInfoByName($summonerName): array
    {
        $endpoint = "/lol/summoner/v4/summoners/by-name/{$summonerName}";
        $url = $this->buildApiUrl($endpoint);

        $response = Http::get($url);

        return $response->json();
    }

    /**
     * The `rotation()` function retrieves the current champion rotations from the League of Legends API.
     * 
     * @return the JSON response from the API call.
     */
    public function rotation()
    {
        $endpoint = "/lol/platform/v3/champion-rotations";
        $url = $this->buildApiUrl($endpoint);

        $response = Http::get($url);

        return $response->json();
    }

    /**
     * The function `getChampionMasteriesBySummonerName` retrieves the top champion masteries for a given
     * summoner name in a specified count.
     * 
     * @param summonerName The summonerName parameter is the name of the summoner for whom you want to
     * retrieve champion masteries.
     * @param count The "count" parameter is an optional parameter that specifies the number of champion
     * masteries to retrieve. By default, it is set to 4, but you can pass a different value to retrieve a
     * different number of champion masteries.
     * 
     * @return the JSON response from the API call to retrieve the champion masteries for a summoner.
     */
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
}
