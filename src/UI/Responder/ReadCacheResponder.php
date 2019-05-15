<?php

namespace App\UI\Responder;

use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Model\Interfaces\PaginatedModelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ReadCacheResponder
 * @author ereshkidal
 */
class ReadCacheResponder
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Response
     */
    private $response;

    /**
     * ReadResponder constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param int $timestamp
     * @throws \Exception
     */
    public function buildCache(int $timestamp): void
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);

        $response = new Response();
        $response->setLastModified($date);
        $response->setPublic();

        $this->response = $response;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isCacheValid(Request $request): bool
    {
        return $this->response->isNotModified($request);
    }

    /**
     * @param ModelInterface|PaginatedModelInterface $model
     * @param string $serializationGroup
     * @return Response
     */
    public function createResponse($model, string $serializationGroup = 'default'): Response
    {
        $json = $this->serializer->serialize($model, 'json', ['groups' => [$serializationGroup]]);
        $this->response->setStatusCode(Response::HTTP_OK);
        $this->response->headers->set('Content-Type', 'application/hal+json');

        return $this->response->setContent($json);
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
