<?php

namespace App\UI\Action\Phone;

use App\UI\Factory\ReadPhoneFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/phones/{id}", methods={"GET"}, name="phone_read")
 *
 * Class ReadPhone
 * @author ereshkidal
 */
class ReadPhone
{
    /**
     * @var ReadPhoneFactory
     */
    private $factory;

    /**
     * ReadPhone constructor.
     * @param ReadPhoneFactory $factory
     */
    public function __construct(ReadPhoneFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Return a phone
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="Must be a valid version 4 Uuid"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Phone successfully returned",
     *      @Model(type=App\Domain\Entity\Phone::class, groups={"phone"})
     * )
     * @SWG\Response(
     *      response=400,
     *      description="Invalid Uuid provided"
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Phone not found"
     * )
     * @SWG\Tag(name="Phones")
     */
    public function __invoke(Request $request)
    {
        return $this->factory->read($request->attributes->get('id'));
    }
}
