<?php

namespace App\Traits;

trait ErrorHandler
{
    public function handleApiError($currentAction, $requestException)
    {
        $response = $requestException->getResponse();

        if ($response) {
            $statusCode = $response->getStatusCode();
            $apiErrorMessage = "An error with status code {$statusCode} occurred while {$currentAction}: {$requestException->getMessage()}";
        } else {
            $apiErrorMessage = "An error occurred while {$currentAction}: {$requestException->getMessage()}";
        }

        activity()->log($apiErrorMessage);

        return null;

    }

    public function handleError($currentAction, $requestException)
    {

        activity()->log("An error occurred while {$currentAction}: {$requestException->getMessage()}");

        return null;

    }
}
