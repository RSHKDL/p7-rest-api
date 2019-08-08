<?php

namespace App\UI\Action\Phone;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use App\Domain\Model\PhoneModel;
use App\UI\Factory\ReadEntityFactory;
use App\UI\Responder\ReadCacheResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/products/phones/{id}", methods={"GET"}, name="phone_read")
 *
 * Class ReadPhone
 * @author ereshkidal
 */
class ReadPhone
{
    /**
     * @var ReadEntityFactory
     */
    private $factory;

    /**
     * @var ReadCacheResponder
     */
    private $responder;

    /**
     * ReadPhone constructor.
     * @param ReadEntityFactory $factory
     * @param ReadCacheResponder $responder
     */
    public function __construct(ReadEntityFactory $factory, ReadCacheResponder $responder)
    {
        $this->factory = $factory;
        $this->responder = $responder;
    }

    /**
     * Return a phone
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
     *      @Model(type=PhoneModel::class, groups={"phone"})
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
     *
     * @param Request $request
     * @param PhoneModel $model
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, PhoneModel $model): Response
    {
        $latestModifiedTimestamp = $this->factory->build($request, $model, true);
        $this->responder->buildCache($latestModifiedTimestamp);

        if ($this->responder->isCacheValid($request) && !$this->responder->getResponse()->getContent()) {
            return $this->responder->getResponse();
        }

        return $this->responder->createResponse(
            $this->factory->build($request, $model),
            'phone'
        );
    }
}
