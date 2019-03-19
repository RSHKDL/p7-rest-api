<?php

namespace App\UI\Responder;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UpdateResponder
 * @author ereshkidal
 */
class UpdateResponder
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * UpdateResponder constructor.
     * @param SerializerInterface $serializer
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        SerializerInterface $serializer,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->serializer = $serializer;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param $entity
     * @param string $serializationGroup
     * @param string $routeName
     * @return Response
     */
    public function __invoke($entity, string $serializationGroup, string $routeName): Response
    {
        $json = $this->serializer->serialize($entity, 'json', ['groups' => [$serializationGroup] ]);

        return new Response($json, Response::HTTP_OK, [
            'location' => $this->urlGenerator->generate($routeName, ['id' => $entity->getId()])
        ]);
    }
}
