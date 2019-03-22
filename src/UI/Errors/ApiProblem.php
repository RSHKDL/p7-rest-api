<?php

namespace App\UI\Errors;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiProblem
 * @author ereshkidal
 */
class ApiProblem
{
    const TYPE_VALIDATION_ERROR = 'validation_error';
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_request_body_format';

    /**
     * @var array
     */
    private static $titles = [
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent'
    ];

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $title;

    /**
     * @var array
     */
    private $extraData = [];

    /**
     * ApiProblem constructor.
     * @param int $statusCode
     * @param string|null $type
     */
    public function __construct(int $statusCode, string $type = null)
    {
        $this->statusCode = $statusCode;

        if ($type === null) {
            $type = 'about:blank';
            $title = isset(Response::$statusTexts[$statusCode])
                ? Response::$statusTexts[$statusCode]
                : 'Unknown status code';
        } else {
            if (!isset(self::$titles[$type])) {
                throw new \InvalidArgumentException('No title for type '.$type);
            }
            $title = self::$titles[$type];
        }

        $this->type = $type;
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            [
                'status'    => $this->statusCode,
                'type'      => $this->type,
                'title'     => $this->title
            ],
            $this->extraData
        );
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setExtraData(string $name, $value)
    {
        $this->extraData[$name] = $value;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
