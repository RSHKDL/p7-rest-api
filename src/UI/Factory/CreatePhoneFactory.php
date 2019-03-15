<?php

namespace App\UI\Factory;

use App\Domain\Entity\Phone;
use App\Domain\Repository\ManufacturerRepository;
use App\Domain\Repository\PhoneRepository;
use App\UI\Form\CreatePhoneType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class CreatePhoneFactory
{
    /**
     * @var PhoneRepository
     */
    private $phoneRepository;

    /**
     * @var ManufacturerRepository
     */
    private $manufacturerRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(
        PhoneRepository $phoneRepository,
        ManufacturerRepository $manufacturerRepository,
        FormFactoryInterface $formFactory
    )
    {
        $this->phoneRepository = $phoneRepository;
        $this->manufacturerRepository = $manufacturerRepository;
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

    /**
     * @param Request $request
     * @param FormInterface $form
     */
    private function processForm(Request $request, FormInterface $form): void
    {
        $data = json_decode($request->getContent(), true);
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }
}
