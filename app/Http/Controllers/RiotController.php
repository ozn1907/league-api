<?php
namespace App\Http\Controllers;

use App\Services\RiotApiService;
use Illuminate\Http\Request;

class RiotController extends Controller
{
    protected $riotApiService;

    public function __construct(RiotApiService $riotApiService)
    {
        $this->middleware('auth');
        $this->riotApiService = $riotApiService;
    }

    public function searchSummoner(Request $request)
    {
        $summonerName = $request->input('summonerName');
        $summonerInfo = $this->riotApiService->getSummonerInfoByName($summonerName);

        return view('summoner-profile', compact('summonerInfo'));
    }
}