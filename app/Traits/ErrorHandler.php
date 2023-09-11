<?php

namespace App\Traits;

trait ErrorHandler
{
    public function handleApiError($requestException, $packageName)
    {
        $response = $requestException->getResponse();

        if ($response) {
            $statusCode = $response->getStatusCode();
            $apiErrorMessage = "An error with status code {$statusCode} occurred while fetching the package {$packageName}: {$requestException->getMessage()}";
        } else {
            $apiErrorMessage = "An error occurred while fetching the package {$packageName}: {$requestException->getMessage()}";
        }

        activity()->log($apiErrorMessage);

        return null;

    }
}
