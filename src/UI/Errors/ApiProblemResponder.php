<?php

namespace App\UI\Errors;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiProblemResponder
 * @author ereshkidal
 */
class ApiProblemResponder
{
    /**
     * @param ApiProblem $apiProblem
     * @return JsonResponse
     */
    public function createResponse(ApiProblem $apiProblem): JsonResponse
    {
        $data = $apiProblem->toArray();
        // making type a URL, to a temporarily fake page
        //@todo use symfony router
        if ($data['type'] !== 'about:blank') {
            $data['type'] = 'http://localhost:8000/docs/errors#'.$data['type'];
        }

        //@todo use signature of JsonResponse to set headers
        $response = new JsonResponse(
            $data,
            $apiProblem->getStatusCode()
        );
        $response->headers->set('Content-Type', 'application/problem+json');

        return $response;
    }
}
