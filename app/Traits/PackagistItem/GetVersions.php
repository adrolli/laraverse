<?php

namespace App\Traits\PackagistItem;

use Composer\Semver\VersionParser;
use Exception;

trait GetVersions
{
    public function getVersions($versions)
    {

        try {
            $versionParser = new VersionParser();

            $releases = [];
            $branches = [];

            foreach ($versions as $versionString => $versionData) {

                try {
                    $normalizedVersion = $versionParser->normalize($versionString);

                    // Matches 9.0.1.0 and 10.0.1 and 100.0 and 10
                    if (preg_match('/^\d+\.\d+(\.\d+)?(\.\d+)?$/', $normalizedVersion)) {
                        $releases[$normalizedVersion] = $versionString;
                    } else {
                        $branches[$versionString] = strtotime($versionData['time']);
                    }

                } catch (\UnexpectedValueException $e) {
                    $branches[$versionString] = strtotime($versionData['time']);
                }

            }

            $versionsData = [
                'releases' => $releases,
                'branches' => $branches,
            ];

            return $versionsData;

        } catch (Exception $Exception) {

            return $this->handleError('GetVersions', $this->version_name, $Exception);

        }

    }
}
