<?php


namespace App\Http\Controllers;

use App\Services\RiotApiService;
use App\Services\DataDragonService;
use App\Services\PaginationService;
use Illuminate\Pagination\Paginator;


class RotationController extends Controller
{
    protected $riotApiService;
    protected $dataDragonService;

    /**
     * The function is a constructor that initializes the RiotApiService and DataDragonService objects and
     * sets the middleware to 'auth'.
     * 
     * @param RiotApiService riotApiService The RiotApiService is a service that interacts with the Riot
     * Games API. It is responsible for making requests to the API and retrieving data related to the game
     * League of Legends.
     * @param DataDragonService dataDragonService The `` parameter is an instance of the
     * `DataDragonService` class. It is being injected into the constructor of the current class. This
     * means that the `DataDragonService` class is a dependency of the current class, and it is being
     * provided through dependency injection.
     */
    public function __construct(RiotApiService $riotApiService, DataDragonService $dataDragonService)
    {
        $this->middleware('auth');
        $this->riotApiService = $riotApiService;
        $this->dataDragonService = $dataDragonService;
    }

    /**
     * The function "showRotation" retrieves the free champion rotation data, combines it with champion
     * data, paginates the free champion IDs, and returns a view with the free rotation and champion data.
     * 
     * @return a view called 'rotation' and passing two variables, 'freeRotation' and 'championData', to
     * the view.
     */
    public function showRotation()
    {
        $freeRotation = $this->riotApiService->rotation();
        $combinedData = $this->dataDragonService->getChampionDataAndNames();
        $championData = $combinedData['championData'];

        $perPage = 8;
        $currentPage = Paginator::resolveCurrentPage() ?: 1;

        $freeChampionIds = collect($freeRotation['freeChampionIds']);
        $freeRotation['freeChampionIds'] = PaginationService::paginateCollection($freeChampionIds, $perPage, $currentPage);

        return view('rotation', compact('freeRotation', 'championData'));
    }
}
