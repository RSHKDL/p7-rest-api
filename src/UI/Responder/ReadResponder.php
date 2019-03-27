<?php

namespace App\UI\Responder;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ReadResponder
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

    public function respond($object, string $serializationGroup): Response
    {
        $json = $this->serializer->serialize($object, 'json', ['groups' => [$serializationGroup]]);

        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/hal+json']);
    }
}
