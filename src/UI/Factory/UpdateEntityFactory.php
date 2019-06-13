<?php

namespace App\UI\Factory;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\Interfaces\Manageable;
use App\UI\Factory\Traits\EntityGetterTrait;
use App\UI\Factory\Traits\ProcessFormTrait;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UpdateEntityFactory
 * @author ereshkidal
 */
class UpdateEntityFactory
{
    use ProcessFormTrait;
    use EntityGetterTrait;

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
     * @todo add security check here to prevent retailer from updating non owned client
     * @param Request $request
     * @param ModelInterface $model
     * @return ModelInterface
     * @throws \Exception
     */
    public function update(Request $request, ModelInterface $model): ModelInterface
    {
        /** @var Manageable|ObjectRepository $repository */
        $repository = $this->entityManager->getRepository($model->getEntityName());
        /** @var EntityInterface $entity */
        $entity = $this->getEntity($request, $repository);

        if (!$entity) {
            throw new NotFoundHttpException(sprintf('%s not found', $model->getEntityShortName()));
        }

        $form = $this->formFactory->create($model->getEntityType(), $entity);
        $this->processForm($request, $form);
        $repository->update($entity);

        return $model::createFromEntity($entity);
    }
}
