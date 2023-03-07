<?php

declare(strict_types=1);

namespace Hakone;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function current;
use function next;
use function reset;

class Runner implements RequestHandlerInterface
{
    private $handler;

    private $middlewares;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @param array<MiddlewareInterface> $middlewares
     */
    public function __construct(RequestHandlerInterface $handler, array $middlewares)
    {
        $this->handler = $handler;
        reset($middlewares);
        $this->middlewares = $middlewares;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = current($this->middlewares);

        if ($middleware === false) {
            $this->request = $request;

            return $this->handler->handle($request);
        }

        next($this->middlewares);

        return $middleware->process($request, $this);
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
