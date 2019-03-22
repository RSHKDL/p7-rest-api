<?php

namespace App\UI\Factory;

use App\Domain\Entity\Phone;
use App\Domain\Repository\PhoneRepository;
use App\UI\Form\CreatePhoneType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @return Phone
     */
    public function create(Request $request): Phone
    {
        $phone = new Phone();
        $form = $this->formFactory->create(CreatePhoneType::class, $phone);
        $this->processForm($request, $form);
        $this->phoneRepository->save($phone);

        return $phone;
    }
}
