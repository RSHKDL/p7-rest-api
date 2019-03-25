<?php

namespace App\Application\Security;

use App\UI\Errors\ApiProblem;
use App\UI\Errors\ApiProblemResponder;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class TokenAuthenticator
 * @author ereshkidal
 */
class TokenAuthenticator extends JWTTokenAuthenticator
{
    /**
     * @var ApiProblemResponder
     */
    private $responder;

    /**
     * TokenAuthenticator constructor.
     * @param JWTTokenManagerInterface $jwtManager
     * @param EventDispatcherInterface $dispatcher
     * @param TokenExtractorInterface $tokenExtractor
     * @param ApiProblemResponder $responder
     */
    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher,
        TokenExtractorInterface $tokenExtractor,
        ApiProblemResponder $responder
    ) {
        parent::__construct($jwtManager, $dispatcher, $tokenExtractor);
        $this->responder = $responder;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $apiProblem = new ApiProblem(401);
        $message = $authException ? $authException->getMessageKey() : 'Missing credentials';
        $apiProblem->setExtraData('detail', $message);

        return $this->responder->createResponse($apiProblem);
    }
}
