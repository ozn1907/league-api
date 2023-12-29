<?php

namespace App\Http\Controllers;

use App\Services\RiotApiService;
use App\Services\DataDragonService;
use Illuminate\Http\Request;

class SearchSummonerController extends Controller
{
    protected $riotApiService;
    protected $dataDragonService;

    /**
     * The index function returns a view for the search page.
     * 
     * @return A view named 'search' is being returned.
     */
    public function index()
    {
        return view('search');
    }

    /**
     * The function is a constructor that initializes the RiotApiService and DataDragonService objects
     * and sets the middleware to require authentication.
     * 
     * @param RiotApiService riotApiService The RiotApiService is a service that interacts with the Riot
     * Games API. It is responsible for making requests to the API and retrieving data related to the
     * game League of Legends.
     * @param DataDragonService dataDragonService The `DataDragonService` is a service that provides
     * access to the Data Dragon API. The Data Dragon API is a tool provided by Riot Games that allows
     * developers to retrieve game data such as champion information, item information, and more.
     */
    public function __construct(RiotApiService $riotApiService, DataDragonService $dataDragonService)
    {
        $this->middleware('auth');
        $this->riotApiService = $riotApiService;
        $this->dataDragonService = $dataDragonService;
    }

    /**
     * The function searches for a summoner by name, retrieves their summoner info and champion
     * masteries, and returns a view with the summoner's profile information.
     * 
     * @param Request request The  parameter is an instance of the Request class, which
     * represents an HTTP request made to the server. It contains information about the request, such as
     * the request method, headers, and input data.
     * @param RiotApiService riotApiService An instance of the RiotApiService class, which is
     * responsible for making API calls to the Riot Games API and retrieving summoner information and
     * champion masteries.
     * @param DataDragonService dataDragonService The `dataDragonService` is an instance of the
     * `DataDragonService` class. It is used to retrieve champion data and names from the Data Dragon
     * API.
     * 
     * @return a view called 'summoner-profile' with the variables 'summonerInfo', 'championMasteries',
     * 'championNames', and 'dataDragonService' passed to it.
     */
    public function searchSummoner(Request $request, RiotApiService $riotApiService, DataDragonService $dataDragonService)
    {
        $summonerName = $request->input('summonerName');
        $summonerInfo = $this->riotApiService->getSummonerInfoByName($summonerName);
        $championMasteries = $this->riotApiService->getChampionMasteriesBySummonerName($summonerName);
        $combinedData = $this->dataDragonService->getChampionDataAndNames();
        $championNames = $combinedData['championNames'];

        return view('summoner-profile', compact('summonerInfo', 'championMasteries', 'championNames', 'dataDragonService'));
    }
}
