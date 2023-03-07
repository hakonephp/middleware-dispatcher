<?php

declare(strict_types=1);

namespace Hakone;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher implements RequestHandlerInterface
{
    private $interceptors;

    private $middlewares;

    private $handler;

    private $decorators;

    /**
     * @param array<MiddlewareInterface> $interceptors
     * @param array<MiddlewareInterface> $middlewares
     * @param array<MiddlewareInterface> $decorators
     */
    public function __construct(array $interceptors, array $middlewares, RequestHandlerInterface $handler, array $decorators)
    {
        $this->interceptors = $interceptors;
        $this->middlewares = $middlewares;
        $this->handler = $handler;
        $this->decorators = $decorators;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        [$request, $response] = $this->interseptRequest($request);
        if ($response !== null) {
            return $response;
        }

        $runner = new Runner($this->handler, $this->middlewares);
        $response = $runner->handle($request);

        return $this->decorateResponse($response, $runner->getRequest());
    }

    /**
     * @return array{ServerRequestInterface, ?ResponseInterface}
     */
    public function interseptRequest(ServerRequestInterface $request): array
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

    public function decorateResponse(ResponseInterface $response, ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->decorators as $decorator) {
            $handler = new ResponseHandler($response);
            $response = $decorator->process($request, $handler);
        }

        return $response;
    }
}
