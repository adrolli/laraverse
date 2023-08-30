<?php

namespace App\Traits;

trait ErrorHandler
{
    public function handleApiError($apiErrorMessage, $requestException)
    {
        $response = $requestException->getResponse();

        activity()->log($apiErrorMessage);

        if ($response) {
            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            return response()->json([
                'error' => $apiErrorMessage,
                'statusCode' => $statusCode,
                'responseBody' => $responseBody,
            ], $statusCode);
        } else {
            return response()->json(['error' => $apiErrorMessage]);
        }

    }
}
