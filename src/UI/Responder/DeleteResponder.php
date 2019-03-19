<?php

namespace App\UI\Responder;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteResponder
 * @author ereshkidal
 */
class DeleteResponder
{
    /**
     * @return Response
     */
    public function __invoke()
    {
       return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
