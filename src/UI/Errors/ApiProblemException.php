<?php

namespace App\UI\Errors;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ApiProblemException
 * @author ereshkidal
 */
class ApiProblemException extends HttpException
{

    /**
     * @var ApiProblem
     */
    private $apiProblem;

    /**
     * ApiProblemException constructor.
     * @param ApiProblem $apiProblem
     * @param \Exception|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct(
        ApiProblem $apiProblem,
        \Exception $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        $this->apiProblem = $apiProblem;
        $statusCode = $this->apiProblem->getStatusCode();
        $message = $this->apiProblem->getTitle();
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * @return ApiProblem
     */
    public function getApiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }
}
