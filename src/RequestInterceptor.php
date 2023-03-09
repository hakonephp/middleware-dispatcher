<?php

declare(strict_types=1);

namespace Hakone;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class RequestInterceptor
{
    private $interceptors;

    /**
     * @param array<MiddlewareInterface> $interceptors
     */
    public function __construct(array $interceptors)
    {
        $this->interceptors = $interceptors;
    }

    /**
     * @return array{ServerRequestInterface, ?ResponseInterface}
     */
    public function interceptRequest(ServerRequestInterface $request): array
    {
        $handler = new InterceptChecker();
        foreach ($this->interceptors as $interceptor) {
            $response = $interceptor->process($request, $handler);
            if (! $response instanceof NotIntercepted) {
                return [$request, $response];
            }

            $request = $handler->getRequest();
        }

        return [$request, null];
    }
}
