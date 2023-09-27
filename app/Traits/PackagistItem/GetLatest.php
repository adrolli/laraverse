<?php

namespace App\Traits\PackagistItem;

use Exception;

trait GetLatest
{
    public function getLatest($versionsData)
    {

        $releases = $versionsData['releases'];
        $branches = $versionsData['branches'];

        try {

            if (! empty($releases)) {
                krsort($releases, SORT_NATURAL);
                $latestRelease = reset($releases);
            }

            if (! empty($branches)) {
                arsort($branches);
                $latestBranch = key($branches);
            }

            $latest = [
                'release' => $latestRelease,
                'branch' => $latestBranch,
            ];

            return $latest;

        } catch (Exception $Exception) {

            return $this->handleError('GetLatest', 'Unknown', $Exception);

        }

    }
}
