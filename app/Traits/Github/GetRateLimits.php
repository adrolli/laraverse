<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;
use GuzzleHttp\Client;

trait GetRateLimits
{
    use ErrorHandler;

    public function getGithubRateLimits()
    {
        $client = new Client();

        $apiUrl = 'https://api.github.com/rate_limit';

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'),
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {

                $rateLimits = json_decode($response->getBody(), true);

                $rates['all']['title'] = 'Rate Limits';
                $rates['all']['limit'] = $rateLimits['rate']['limit'];
                $rates['all']['used'] = $rateLimits['rate']['used'];
                $rates['all']['remaining'] = $rateLimits['rate']['remaining'];
                $rates['all']['timestamp'] = $rateLimits['rate']['reset'];
                $rates['all']['datetime'] = date('Y-m-d H:i:s', $rates['all']['timestamp']);
                $rates['all']['minutes'] = round(abs($rates['all']['timestamp'] - time()) / 60, 2).' minutes';

                $rates['core']['title'] = 'Core Limits';
                $rates['core']['limit'] = $rateLimits['resources']['core']['limit'];
                $rates['core']['used'] = $rateLimits['resources']['core']['used'];
                $rates['core']['remaining'] = $rateLimits['resources']['core']['remaining'];
                $rates['core']['timestamp'] = $rateLimits['resources']['core']['reset'];
                $rates['core']['datetime'] = date('Y-m-d H:i:s', $rates['core']['timestamp']);
                $rates['core']['minutes'] = round(abs($rates['core']['timestamp'] - time()) / 60, 2).' minutes';

                $rates['search']['title'] = 'Search Limits';
                $rates['search']['limit'] = $rateLimits['resources']['search']['limit'];
                $rates['search']['used'] = $rateLimits['resources']['search']['used'];
                $rates['search']['remaining'] = $rateLimits['resources']['search']['remaining'];
                $rates['search']['timestamp'] = $rateLimits['resources']['search']['reset'];
                $rates['search']['datetime'] = date('Y-m-d H:i:s', $rates['search']['timestamp']);
                $rates['search']['minutes'] = round(abs($rates['search']['timestamp'] - time()) / 60, 2).' minutes';

                return $rates;

            } else {

                $this->handleApiError('Get Rate Limits', $response->getBody());

                return null;

            }

        } catch (\Exception $e) {

            $this->handleApiError('Rate Limits', $e);

            return null;
        }
    }
}
