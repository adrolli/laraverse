<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;
use GuzzleHttp\Client;

trait GetContents
{
    use ErrorHandler;

    public function getGitHubContents($slug)
    {
        $client = new Client();

        $apiUrl = "https://api.github.com/repos/{$slug}/contents/";

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'),
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $contents = json_decode($response->getBody(), true);

                $filesAndDirectories = [
                    'artisan',
                    'composer.json',
                    'package.json',
                    'vite.config.js',
                    'tailwind.config.js',
                    'docker-compose.yml',
                    'README.md',
                    'LICENSE.md',
                    'CHANGELOG.md',
                    'app',
                    'config',
                    'database',
                    'src',
                    'public',
                    'resources',
                    'routes',
                    'tests',
                ];

                $results = [];

                foreach ($filesAndDirectories as $item) {
                    $found = false;
                    foreach ($contents as $contentItem) {
                        if ($contentItem['name'] === $item) {

                            if ($contentItem['type'] === 'file') {
                                $results[$item] = $contentItem['download_url'];
                            } else {
                                $results[$item] = $contentItem['url'];
                            }
                            $found = true;
                            break;
                        }
                    }
                    if (! $found) {
                        $results[$item] = false;
                    }
                }

                return $results;

            } else {

                $this->handleApiError($apiUrl, $response->getBody());

                return null;

            }

        } catch (\Exception $e) {

            $this->handleApiError($apiUrl, $e);

            return null;
        }
    }
}
