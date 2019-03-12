<?php

namespace App\UI\Responder;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CreateResponder
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        SerializerInterface $serializer,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->serializer = $serializer;
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke($entity, string $serializationGroup, string $routeName): Response
    {
        $json = $this->serializer->serialize($entity, 'json', ['groups' => [$serializationGroup] ]);

        return new Response($json, Response::HTTP_CREATED, [
            'location' => $this->urlGenerator->generate($routeName, ['id' => $entity->getId()])
        ]);
    }
}
