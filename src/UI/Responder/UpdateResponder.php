<?php

namespace App\UI\Responder;

use App\Domain\Model\ClientModel;
use App\Domain\Model\Interfaces\ModelInterface;
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
     * @param ModelInterface $model
     * @param string $serializationGroup
     * @param string $routeName
     * @return Response
     */
    public function __invoke(ModelInterface $model, string $serializationGroup, string $routeName): Response
    {
        $json = $this->serializer->serialize($model, 'json', [
            'groups' => [$serializationGroup],
            'json_encode_options' => JSON_UNESCAPED_SLASHES
        ]);

        return new Response($json, Response::HTTP_OK, [
            'location' => $this->urlGenerator->generate($routeName, $this->generateParamsFromModel($model))
        ]);
    }

    /**
     * @param ModelInterface $model
     * @return array
     */
    private function generateParamsFromModel(ModelInterface $model): array
    {
        if ($model instanceof ClientModel) {
            return [
                'retailerUuid' => $model->getParentId(),
                'clientUuid' => $model->getId(),
            ];
        }

        return [
            'id' => $model->getId()
        ];
    }
}
