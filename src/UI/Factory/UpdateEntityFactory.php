<?php

namespace App\UI\Factory;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\Interfaces\Manageable;
use App\UI\Factory\Traits\ProcessFormTrait;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UpdateEntityFactory
 * @author ereshkidal
 */
class UpdateEntityFactory
{
    use ProcessFormTrait;

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
     * @todo: l53 seems ugly af
     * @param Request $request
     * @param string $id
     * @param ModelInterface $model
     * @return ModelInterface
     * @throws \Exception
     */
    public function update(Request $request, string $id, ModelInterface $model): ModelInterface
    {
        /** @var Manageable|ObjectRepository $repository */
        $repository = $this->entityManager->getRepository($model->getEntityName());
        $entity = $repository->find($id);
        //@todo: seems to violate the open-close principle and interface-segregation
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
