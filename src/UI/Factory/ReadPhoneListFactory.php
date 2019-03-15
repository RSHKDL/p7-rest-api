<?php

namespace App\UI\Factory;

use App\Domain\Repository\PhoneRepository;
use App\UI\Responder\ReadResponder;

class ReadPhoneListFactory
{
    /**
     * @var PhoneRepository
     */
    private $repository;

    /**
     * @var ReadResponder
     */
    private $responder;

    /**
     * ReadPhoneListFactory constructor.
     * @param PhoneRepository $repository
     * @param ReadResponder $responder
     */
    public function __construct(
        PhoneRepository $repository,
        ReadResponder $responder
    ){
        $this->repository = $repository;
        $this->responder = $responder;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read()
    {
        $phones = $this->repository->findAll();

        return $this->responder->respond($phones, 'phone_list');
    }
}
