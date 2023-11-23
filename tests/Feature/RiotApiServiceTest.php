<?php

use Tests\TestCase;
use App\Services\RiotApiService;

class RiotApiServiceTest extends TestCase
{
    /**
     * @var array
     */
    private $result;

    public function testGetSummonerInfoByName()
    {
        $riotApiService = new RiotApiService();
        
        $this->result = $riotApiService->getSummonerInfoByName('BootlegIrelia');

        $this->assertIsArray($this->result);
        $this->assertArrayHasKey('summonerLevel', $this->result);
        $this->assertArrayHasKey('accountId', $this->result);
    }

    public function testGetProfileIconUrl()
    {
        $riotApiService = new RiotApiService();

        $profileIconId = 123;
        $version = '13.22.1';

        $url = $riotApiService->getProfileIconUrl($profileIconId, $version);

        $expectedUrl = "https://ddragon.leagueoflegends.com/cdn/{$version}/img/profileicon/{$profileIconId}.png";

        $this->assertEquals($expectedUrl, $url);
    }

}

