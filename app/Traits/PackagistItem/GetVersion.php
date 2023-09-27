<?php

namespace App\Traits\PackagistItem;

use Exception;

trait GetVersion
{
    public function getVersion($versionString, $versionData)
    {
        try {

            $versionData = [

                'version_string' => $versionString,
                'version_dist_url' => $versionData['dist']['url'],
                'version_dist_type' => $versionData['dist']['type'],
                'version_dist_shasum' => $versionData['dist']['shasum'],
                'version_dist_reference' => $versionData['dist']['reference'],
                'version_name' => $versionData['name'],
                'version_time' => $versionData['time'],
                'version_type' => $versionData['type'],
                'version_source_url' => $versionData['source']['url'],
                'version_source_type' => $versionData['source']['type'],
                'version_source_reference' => $versionData['source']['reference'],
                'version_authors' => $versionData['authors'],
                'version_licenses' => $versionData['license'],
                'version_requires' => $versionData['require'],

            ];

            return $versionData;

        } catch (Exception $Exception) {

            return $this->handleError('GetVersions', $this->version_name, $Exception);

        }
    }
}
