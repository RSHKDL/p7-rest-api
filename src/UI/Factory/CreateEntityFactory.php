<?php

namespace App\UI\Factory;

use App\Application\Helper\LinksHelper;
use App\Application\Validation\FormValidator;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Repository\Interfaces\Manageable;
use App\UI\Factory\Traits\ProcessFormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateEntityFactory
 * @author ereshkidal
 */
final class CreateEntityFactory
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
     * @var FormValidator
     */
    private $formValidator;

    /**
     * @var LinksHelper
     */
    private $linksHelper;

    /**
     * CreateEntityFactory constructor.
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
     * @param array|null $options
     * @return ModelInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function create(Request $request, ModelInterface $model, ?array $options = []): ModelInterface
    {
        $entityName = $model->getEntityName();
        $entity = new $entityName();
        $form = $this->formFactory->create($model->getEntityType(), $entity);
        $this->processForm($request, $form);

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->formValidator->throwValidationErrorException($form);
        }

        /** @var Manageable $repository */
        $repository = $this->entityManager->getRepository($model->getEntityName());
        //@todo i don't like this behavior... not really scalable
        if (method_exists($entity, 'setRetailer')) {
            $entity->setRetailer($options['retailer']);
        }
        $repository->saveOrUpdate($entity);
        $model = $model::createFromEntity($entity);
        $this->linksHelper->addLink($model);

        return $model;
    }
}
