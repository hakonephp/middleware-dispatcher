<?php

declare(strict_types=1);

namespace Hakone;

use Closure;
use Hakone\Helper\TestClosureHandler;
use Hakone\Helper\TestClosureMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @param Closure(ServerRequestInterface, RequestHandlerInterface): ResponseInterface $callback
 */
function middleware(Closure $callback): TestClosureMiddleware
{
    return new TestClosureMiddleware($callback);
}

/**
 * @param Closure(ServerRequestInterface): ResponseInterface $callback
 */
function response_handler(Closure $callback): TestClosureHandler
{
    return new TestClosureHandler($callback);
}
