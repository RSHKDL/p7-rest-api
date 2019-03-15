<?php

namespace App\UI\Factory;

use App\Domain\Repository\PhoneRepository;
use App\UI\Responder\ReadResponder;
use Symfony\Component\HttpFoundation\Request;

class ReadPhoneFactory
{
    /**
     * @var PhoneRepository
     */
    private $repository;

    /**
     * @var ReadResponder
     */
    private $responder;

    public function __construct(
        PhoneRepository $repository,
        ReadResponder $responder
    ){
        $this->repository = $repository;
        $this->responder = $responder;
    }

    /**
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read(string $id)
    {
        $phone = $this->repository->find($id);

        return $this->responder->respond($phone, 'phone');
    }
}
