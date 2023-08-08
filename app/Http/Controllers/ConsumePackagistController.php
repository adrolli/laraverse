<?php

namespace App\Http\Controllers;

use App\Models\Item;
use GuzzleHttp\Client;

class ConsumePackagistController extends Controller
{
    public function searchRepositories()
    {
        $query = 'laravel';
        $packagistApiUrl = 'https://packagist.org/search.json';
        $client = new Client();

        try {
            $response = $client->get($packagistApiUrl, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'q' => $query,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            dd($data);

            // Process the data or return it to the view...
            $repositories = $data['items'];
            $processedData = [];

            /*

            "name" => "usetall/tallui-web-components"
            "description" => "This is my package tallui-web-components"
            "url" => "https://packagist.org/packages/usetall/tallui-web-components"
            "repository" => "https://github.com/usetall/tallui-web-components"
            "downloads" => 2
            "favers" => 4
            */

            foreach ($repositories as $repository) {
                // Fetch detailed repository information
                $repoDetailsResponse = $client->get($repository['url'], [
                    'headers' => [
                        'Authorization' => 'Bearer '.$accessToken,
                        'Accept' => 'application/json',
                    ],
                ]);

                $repoDetails = json_decode($repoDetailsResponse->getBody(), true);

                // Fetch repository contents
                $contentsUrl = "https://api.github.com/repos/{$repoDetails['full_name']}/contents";

                $contentsResponse = $client->get($contentsUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer '.$accessToken,
                        'Accept' => 'application/json',
                    ],
                ]);

                $contents = json_decode($contentsResponse->getBody(), true);

                // Check if the files exist
                $fileNames = ['composer.json', 'package.json', 'README.md', 'LICENSE.md'];
                $existingFiles = [];

                foreach ($fileNames as $fileName) {
                    $exists = false;
                    foreach ($contents as $content) {
                        if ($content['name'] === $fileName) {
                            $exists = true;
                            break;
                        }
                    }
                    $existingFiles[$fileName] = $exists;
                }

                // dd($repoDetails['security_and_analysis']);

                // Transform the data to match your schema
                $itemData = [
                    'title' => $repoDetails['full_name'],
                    'slug' => $repoDetails['full_name'],
                    'description' => $repoDetails['full_name'],
                    'vendor_id' => $repoDetails['id'],
                    'type_id' => $repoDetails['id'],
                    'website' => $repoDetails['full_name'],

                    // Map other fields here
                ];

                // Store the transformed data in the database
                Item::create($itemData);

                return response()->json(['message' => 'Item inserted successfully']);

                echo "Repository: {$repoDetails['full_name']}<br>";
                echo "Owner: {$repoDetails['owner']['login']}<br>";
                echo "Default-Branch: {$repoDetails['default_branch']}<br>";
                echo 'Files:<br>';
                foreach ($existingFiles as $fileName => $exists) {
                    echo "- $fileName: ".($exists ? 'Exists' : 'Does not exist').'<br>';
                }
                echo '<br>';

                // Rest of your code to process other details
                // ...

                $processedData[] = $repoDetails;
            }

            return $processedData;
        } catch (Exception $e) {
            // Handle API request errors here.
        }
    }

    public function getRepositoryInfo($repo)
    {

    }

    public function getRepositoryFiles($repo)
    {

    }
}
