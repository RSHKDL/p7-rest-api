<?php

namespace App\UI\Factory;

use App\Domain\Entity\Phone;
use App\Domain\Repository\PhoneRepository;
use App\UI\Form\CreatePhoneType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdatePhoneFactory
 * @author ereshkidal
 */
class UpdatePhoneFactory
{
    /**
     * @var PhoneRepository
     */
    private $repository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * UpdatePhoneFactory constructor.
     * @param PhoneRepository $repository
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        PhoneRepository $repository,
        FormFactoryInterface $formFactory
    ) {
        $this->repository = $repository;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return Phone
     */
    public function update(Request $request, string $id): Phone
    {
        /** @var Phone $phone */
        $phone = $this->repository->find($id);
        $form = $this->formFactory->create(CreatePhoneType::class, $phone);
        $this->processForm($request, $form);
        $this->repository->save($phone);

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
