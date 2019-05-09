<?php

namespace App\UI\Factory;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UpdateEntityFactory
 * @author ereshkidal
 */
class UpdateEntityFactory extends AbstractFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * UpdateEntityFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory
    ) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param string $id
     * @param ModelInterface $model
     * @return ModelInterface
     * @throws \Exception
     */
    public function update(Request $request, string $id, ModelInterface $model): ModelInterface
    {
        $repository = $this->entityManager->getRepository($model->getEntityName());
        $entity = $repository->find($id);

        if (!$entity instanceof EntityInterface) {
            throw new UnprocessableEntityHttpException(
                'This entity does not implement EntityInterface'
            );
        }

        $form = $this->formFactory->create($model->getEntityType(), $entity);
        $this->processForm($request, $form);
        $repository->update($entity);

        return $model::createFromEntity($entity);
    }
}
