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
     * The function retrieves champion data and names from the League of Legends API using a specified
     * version or the default version.
     * 
     * @param version The version parameter is used to specify the version of the data that you want to
     * retrieve. If a version is not provided, it will default to the value stored in the
     *  property.
     * 
     * @return an array containing the champion data and champion names.
     */
    public function getChampionDataAndNames($version = null)
    {
        $version = $version ?: $this->defaultVersion;
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/data/en_US/champion.json";

        $response = Http::get($url);

        $championData = $response->json();

        $championNames = collect($championData['data'])->pluck('name', 'key')->all();
        return compact('championData', 'championNames');
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

    /**
     * The function `getProfileIconUrl` returns the URL of a profile icon image based on the given profile
     * icon ID and version.
     * 
     * @param profileIconId The profileIconId parameter is the unique identifier for a specific profile
     * icon in the game. Each profile icon has a different profileIconId associated with it.
     * @param version The "version" parameter is an optional parameter that specifies the version of the
     * data dragon API to use. If a version is provided, it will be used in the URL to fetch the profile
     * icon image. If no version is provided, the default version specified by the variable
     * "->defaultVersion"
     * 
     * @return a URL string that represents the profile icon image for a given profileIconId.
     */
    public function getProfileIconUrl($profileIconId, $version = null)
    {
        $version = $version ?: $this->defaultVersion;
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/img/profileicon/{$profileIconId}.png";

        return $url;
    }
    /**
     * The function `getChampionIconUrl` returns the URL of a champion's icon image based on the champion
     * ID and version.
     * 
     * @param championId The championId parameter is the unique identifier for a specific champion in a
     * game. It is used to retrieve the icon image for that champion.
     * @param version The `version` parameter is an optional parameter that specifies the version of the
     * champion data to use. If no version is provided, it will default to the `defaultVersion` property of
     * the class.
     * 
     * @return the URL of the champion icon image.
     */

    public function getChampionIconUrl($championId, $version = null)
    {
        $version = $version ?: $this->defaultVersion;
        $championData = $this->getChampionData($version);

        $champion = collect($championData)->firstWhere('key', $championId);

        if ($champion) {
            $championName = $champion['name'];

            $championNameInUrl = strpos($championName, "'") !== false
                ? ucfirst(strtolower(str_replace(['\'', ' '], ['', ''], $championName)))
                : str_replace(' ', '', $championName);

            return "{$this->dataDragonBaseUrl}/cdn/{$version}/img/champion/{$championNameInUrl}.png";
        }

        return "{$this->dataDragonBaseUrl}/cdn/{$version}/img/champion/{$championId}.png";
    }

    /**
     * The function retrieves champion data from the Riot Games API based on the specified version.
     * 
     * @param version The version parameter is a string that represents the version of the game data you
     * want to retrieve. It is used to construct the URL for the API request.
     * 
     * @return the 'data' array from the JSON response.
     */
    protected function getChampionData($version)
    {
        $url = "{$this->dataDragonBaseUrl}/cdn/{$version}/data/en_US/champion.json";
        $response = Http::get($url);

        return $response->json()['data'];
    }
}
