<?php

namespace App\UI\Responder;

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
     * ReadResponder constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $object
     * @param Request $request
     * @param string $serializationGroup
     * @return Response
     */
    public function respond($object, Request $request, string $serializationGroup = 'default'): Response
    {
        $json = $this->serializer->serialize($object, 'json', ['groups' => [$serializationGroup]]);

        $response = new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/hal+json']);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }
}
