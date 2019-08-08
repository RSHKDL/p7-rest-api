<?php

namespace App\UI\Factory;

use App\Application\Helper\LinksHelper;
use App\Application\Validation\FormValidator;
use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\Interfaces\Manageable;
use App\UI\Factory\Traits\EntityGetterTrait;
use App\UI\Factory\Traits\ProcessFormTrait;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateEntityFactory
 * @author ereshkidal
 */
final class UpdateEntityFactory
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
     * @var FormValidator
     */
    private $formValidator;

    /**
     * @var LinksHelper
     */
    private $linksHelper;

    /**
     * UpdateEntityFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $formFactory
     * @param FormValidator $formValidator
     * @param LinksHelper $linksHelper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        FormValidator $formValidator,
        LinksHelper $linksHelper
    ) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->formValidator = $formValidator;
        $this->linksHelper = $linksHelper;
    }

    /**
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
        $entity = $this->getEntity($request, $repository, $model->getEntityShortName());

        $form = $this->formFactory->create($model->getEntityType(), $entity);
        $this->processForm($request, $form);
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->formValidator->throwValidationErrorException($form);
        }

        $repository->saveOrUpdate($entity, true);
        $model = $model::createFromEntity($entity);
        $this->linksHelper->addLink($model);

        return $model;
    }
}
