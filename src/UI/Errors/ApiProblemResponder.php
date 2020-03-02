<?php

namespace App\UI\Errors;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ApiProblemResponder
 * @author ereshkidal
 */
class ApiProblemResponder
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ApiProblemResponder constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

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
            $this->serializer->serialize($data, 'json', [
                'json_encode_options' => JSON_UNESCAPED_SLASHES
            ]),
            $apiProblem->getStatusCode(),
            [],
            true
        );
        $response->headers->set('Content-Type', 'application/problem+json');

        return $response;
    }
}
