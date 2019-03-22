<?php

namespace App\UI\Factory;

use App\Domain\Repository\PhoneRepository;
use App\UI\Responder\ReadResponder;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if (!Uuid::isValid($id)) {
            throw new BadRequestHttpException('The Uuid you provided is invalid');
        }

        $phone = $this->repository->find($id);

        if (!$phone) {
            throw new NotFoundHttpException(
                sprintf('No phone found with id: %s', $id)
            );
        }

        return $this->responder->respond($phone, 'phone');
    }
}
