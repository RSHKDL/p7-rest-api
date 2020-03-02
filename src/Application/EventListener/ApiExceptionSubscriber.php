<?php

namespace App\Application\EventListener;

use App\UI\Errors\ApiProblem;
use App\UI\Errors\ApiProblemException;
use App\UI\Errors\ApiProblemResponder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ApiExceptionSubscriber
 * @author ereshkidal
 */
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var bool
     */
    private $debug;

    /**
     * @var ApiProblemResponder
     */
    private $responder;

    /**
     * ApiExceptionSubscriber constructor.
     * @param bool $debug
     * @param ApiProblemResponder $responder
     */
    public function __construct(bool $debug, ApiProblemResponder $responder)
    {
        $this->debug = $debug;
        $this->responder = $responder;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        if (strpos($event->getRequest()->getPathInfo(), '/api') !== 0) {
            return;
        }

        $e = $event->getThrowable();

        $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

        if ($this->debug && $statusCode >= 500) {
            return;
        }

        if ($e instanceof ApiProblemException) {
            $apiProblem = $e->getApiProblem();
        } else {
            $apiProblem = new ApiProblem($statusCode);
        }

        if ($e instanceof HttpExceptionInterface) {
            $apiProblem->setExtraData('detail', $e->getMessage());
        }

        $event->setResponse($this->responder->createResponse($apiProblem));
    }
}
