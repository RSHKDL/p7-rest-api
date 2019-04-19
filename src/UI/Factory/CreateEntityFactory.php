<?php

namespace App\UI\Factory;

use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateEntityFactory
 * @author ereshkidal
 */
class CreateEntityFactory extends AbstractFactory
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
     * CreateEntityFactory constructor.
     * @param PhoneRepository $entityManager
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param ModelInterface $model
     * @return ModelInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function create(Request $request, ModelInterface $model): ModelInterface
    {
        $entityName = $model->getEntityName();
        $entity = new $entityName();
        $form = $this->formFactory->create($model->getEntityType(), $entity);
        $this->processForm($request, $form);
        $this->entityManager->getRepository($model->getEntityName())->save($entity);

        return $model::createFromEntity($entity);
    }
}