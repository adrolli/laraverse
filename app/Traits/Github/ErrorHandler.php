<?php

namespace App\Traits\Github;

trait ErrorHandler
{
    public function handleApiError($requestException, $repositoryName)
    {
        $response = $requestException->getResponse();

        if ($response) {
            $statusCode = $response->getStatusCode();
            $apiErrorMessage = "An error with status code {$statusCode} occurred while fetching the GitHub repository {$repositoryName}: {$requestException->getMessage()}";
        } else {
            $apiErrorMessage = "An error occurred while fetching the GitHub repository {$repositoryName}: {$requestException->getMessage()}";
        }

        activity()->log($apiErrorMessage);

        return null;

    }
}
