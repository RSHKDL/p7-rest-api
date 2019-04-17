<?php

namespace App\UI\Responder;

use App\Domain\Model\Interfaces\ModelInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CreateResponder
 * @author ereshkidal
 */
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

    /**
     * CreateResponder constructor.
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
     * @param ModelInterface $model
     * @param string $serializationGroup
     * @param string $routeName
     * @return Response
     */
    public function __invoke(ModelInterface $model, string $serializationGroup, string $routeName): Response
    {
        $json = $this->serializer->serialize($model, 'json', ['groups' => [$serializationGroup] ]);

        return new Response($json, Response::HTTP_CREATED, [
            'location' => $this->urlGenerator->generate($routeName, ['id' => $model->getId()])
        ]);
    }
}
