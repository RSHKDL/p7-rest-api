<?php

namespace App\UI\Form\DataTransformer;

use App\Domain\Entity\Manufacturer;
use App\Domain\Repository\ManufacturerRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Form\DataTransformerInterface;

class ManufacturerTransformer implements DataTransformerInterface
{
    /**
     * @var ManufacturerRepository
     */
    private $repository;

    public function __construct(ManufacturerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Transforms an object (Manufacturer) to a string (name).
     *
     * @param null|Manufacturer $manufacturer
     * @return mixed|string
     */
    public function transform($manufacturer)
    {
        if (null === $manufacturer) {
            return '';
        }

        return $manufacturer->getName();
    }

    /**
     * Transforms a string ($manufacturerName) to an object (Manufacturer).
     *
     * @param mixed $manufacturerName
     * @return Manufacturer|mixed
     * @throws NonUniqueResultException
     */
    public function reverseTransform($manufacturerName)
    {

        $manufacturer = $this->repository->findOneByName($manufacturerName);

        if (null === $manufacturer) {
            $manufacturer = new Manufacturer($manufacturerName);
        }

        return $manufacturer;
    }
}
