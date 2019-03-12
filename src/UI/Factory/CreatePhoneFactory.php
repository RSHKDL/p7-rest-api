<?php

namespace App\UI\Factory;

use App\Domain\Entity\Phone;
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
    private $repository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(
        PhoneRepository $repository,
        FormFactoryInterface $formFactory
    )
    {
        $this->repository = $repository;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @return Phone
     */
    public function create(Request $request)
    {
        $phone = new Phone();
        $form = $this->formFactory->create(CreatePhoneType::class, $phone);
        $this->processForm($request, $form);
        $this->repository->save($phone);

        return $phone;
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     */
    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }
}
