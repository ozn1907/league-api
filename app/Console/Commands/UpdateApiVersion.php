<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class UpdateApiVersion extends Command
{
    protected $signature = 'update:api-version';
    protected $description = 'Update the API version in .env file and create/push a new branch if needed';

    public function handle()
    {
        try {
            Log::info('Checking for API version update...');
            // Fetch the latest version from the API
            $latestVersion = Http::get('https://ddragon.leagueoflegends.com/api/versions.json')->json()[0];

            // Check if the API version is already up to date
            if (env('DEFAULT_VERSION') == $latestVersion) {
                $this->info('API version is already up to date (' . $latestVersion . ')');
                Log::info('API version is already up to date.');
            } else {
                // Update the .env file
                $envFile = base_path('.env');
                File::put($envFile, str_replace(
                    'DEFAULT_VERSION=' . env('DEFAULT_VERSION'),
                    'DEFAULT_VERSION=' . $latestVersion,
                    File::get($envFile)
                ));

                $this->info('API version updated to ' . $latestVersion);
                Log::info('API version updated successfully.');

                // Create and push a new branch with the updated version
                $this->createAndPushBranch($latestVersion);
            }
        } catch (\Exception $e) {
            $this->error('Failed to check/update API version. Error: ' . $e->getMessage());
            Log::error('Failed to check/update API version. Error: ' . $e->getMessage());
        }
    }

    private function createAndPushBranch($version)
    {
        // Define a branch name based on the version
        $branchName = 'api-version-' . str_replace('.', '-', $version);

        // Create a new branch using Git command
        $process = new Process(['git', 'checkout', '-b', $branchName]);
        $process->run();

        // Check if the process was successful
        if ($process->isSuccessful()) {
            $this->info('New branch created: ' . $branchName);

            // Push the new branch to the remote repository
            $pushProcess = new Process(['git', 'push', 'origin', $branchName]);
            $pushProcess->run();

            // Check if the push process was successful
            if ($pushProcess->isSuccessful()) {
                $this->info('New branch pushed to the remote repository.');

                // Request a merge using GitLab API
                $this->requestMerge($branchName);
            } else {
                $this->error('Failed to push the new branch. Error: ' . $pushProcess->getErrorOutput());
            }
        } else {
            $this->error('Failed to create a new branch. Error: ' . $process->getErrorOutput());
        }
    }

    private function requestMerge($branchName)
    {
        // Assuming your GitLab project URL is 'https://github.com/ozn1907/league-api'
        $gitlabApiUrl = 'https://github.com/ozn1907/league-api';

        $response = Http::post($gitlabApiUrl, [
            'source_branch' => $branchName,
            'target_branch' => 'main',
            'title' => 'Merge ' . $branchName,
            'remove_source_branch' => true,
        ]);

        if ($response->successful()) {
            $this->info('Merge request successfully created.');
        } else {
            $this->error('Failed to create a merge request. Error: ' . $response->body());
        }
    }
}
