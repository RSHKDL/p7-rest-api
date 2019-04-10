<?php

namespace App\UI\Factory;

use App\Domain\Entity\Phone;
use App\Domain\Model\Interfaces\ModelInterface;
use App\Domain\Model\PhoneModel;
use App\Domain\Repository\PhoneRepository;
use App\UI\Form\CreatePhoneType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreatePhoneFactory
 * @author ereshkidal
 */
class CreatePhoneFactory extends AbstractFactory
{
    /**
     * @var PhoneRepository
     */
    private $phoneRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * CreatePhoneFactory constructor.
     * @param PhoneRepository $phoneRepository
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        PhoneRepository $phoneRepository,
        FormFactoryInterface $formFactory
    )
    {
        $this->phoneRepository = $phoneRepository;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param PhoneModel $phoneModel
     * @return ModelInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function create(Request $request, PhoneModel $phoneModel): ModelInterface
    {
        $phone = new Phone();
        $form = $this->formFactory->create(CreatePhoneType::class, $phone);
        $this->processForm($request, $form);
        $this->phoneRepository->save($phone);

        return $phoneModel::createFromEntity($phone);
    }
}
