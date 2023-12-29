<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DataDragonService
{
    /* The code is declaring two protected properties, `` and ``, in the
    `DataDragonService` class. These properties are used to store the base URL and default version for
    the Data Dragon API, which is used to retrieve champion data and profile icons for the League of
    Legends game. The `protected` visibility means that these properties can only be accessed within the
    class and its subclasses. */
    protected $dataDragonBaseUrl;
    protected $defaultVersion;

    /**
     * The function initializes the dataDragonBaseUrl and defaultVersion properties using values from the
     * application configuration.
     */
    public function __construct()
    {
        $this->dataDragonBaseUrl = config('app.data_dragon_base_url');
        $this->defaultVersion = config('app.default_version');
    }
    /**
     * The function retrieves champion data and names from the League of Legends API using a specified
     * version or the default version.
     * 
     * @param version The version parameter is used to specify the version of the data to retrieve. If a
     * version is not provided, it will default to the value stored in the  variable.
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
     * The function `getChampionIconUrl` returns the URL of a champion's icon image based on the champion
     * ID and version.
     * 
     * @param championId The championId parameter is the unique identifier for a specific champion in a
     * game or application. It is used to retrieve the icon image for that champion.
     * @param version The `version` parameter is an optional parameter that specifies the version of the
     * champion data to use. If no version is provided, it will default to the `defaultVersion` property of
     * the class.
     * 
     * @return The function `getChampionIconUrl` returns the URL of the champion icon image.
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
}
