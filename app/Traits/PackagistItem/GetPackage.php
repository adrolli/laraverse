<?php

namespace App\Traits\PackagistItem;

use App\Models\PackagistPackage;
use Exception;

trait GetPackage
{
    public function getPackage($slug)
    {
        try {

            $package = PackagistPackage::where('slug', $slug)->first();
            $jsonData = $package->data;

            $packageData = [
                'id' => $package->id,
                'title' => $package->title,
                'slug' => $package->slug,
                'jsonData' => $jsonData,
                'name' => $jsonData['name'],
                'time' => $jsonData['time'],
                'type' => $jsonData['type'],
                'favers' => $jsonData['favers'],
                'language' => $jsonData['language'],
                'description' => $jsonData['description'],
                'dependents' => $jsonData['dependents'],
                'suggesters' => $jsonData['suggesters'],
                'repository' => $jsonData['repository'],
                'versions' => $jsonData['versions'],
                'downloads_daily' => $jsonData['downloads']['daily'],
                'downloads_total' => $jsonData['downloads']['total'],
                'downloads_monthly' => $jsonData['downloads']['monthly'],
                'maintainers' => $jsonData['maintainers'],
                'github_forks' => $jsonData['github_forks'],
                'github_stars' => $jsonData['github_stars'],
                'github_watchers' => $jsonData['github_watchers'],
                'github_open_issues' => $jsonData['github_open_issues'],
            ];

            return $packageData;

        } catch (Exception $Exception) {

            return $this->handleError('GetPackage', $slug, $Exception);

        }
    }
}
