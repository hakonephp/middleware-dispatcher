<?php

declare(strict_types=1);

namespace Hakone;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher implements RequestHandlerInterface
{
    /**
     * @param array<MiddlewareInterface> $middlewares
     * @param array<MiddlewareInterface> $decorators
     */
    public function __construct(
        private RequestInterceptor $interceptor,
        private array $middlewares,
        private RequestHandlerInterface $handler,
        private array $decorators
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        [$request, $response] = $this->interceptor->interceptRequest($request);
        if ($response !== null) {
            return $response;
        }

        $runner = new Runner($this->handler, $this->middlewares);
        $response = $runner->handle($request);

        return $this->decorateResponse($response, $runner->getRequest());
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
