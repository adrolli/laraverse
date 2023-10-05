<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;

trait ShowRateLimits
{
    use ErrorHandler;

    public function showGithubRateLimits($rates)
    {
        try {

            foreach ($rates as $rate => $data) {
                echo "<h2>{$rates[$rate]['title']}</h2>";
                echo "Rate Limit: {$rates[$rate]['title']}";
                echo '<br>';
                echo "Used Limit: {$rates[$rate]['used']}";
                echo '<br>';
                echo "Remaining: {$rates[$rate]['remaining']}";
                echo '<br>';
                echo "Reset date: {$rates[$rate]['datetime']}";
                echo '<br>';
                echo "Reset mins: {$rates[$rate]['minutes']}";
                echo '<br>';
                echo '<br>';
            }

        } catch (\Exception $e) {

            $this->handleError('Show Rate Limits', $e);

            return null;
        }
    }
}
