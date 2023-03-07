<?php

declare(strict_types=1);

namespace Hakone;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @param array{
 *     interceptors: array<MiddlewareInterface>,
 *     middlewares: array<MiddlewareInterface>,
 *     handler: RequestHandlerInterface,
 *     decorators: array<MiddlewareInterface>
 * } $handlers
 */
function relay(array $handlers): RequestHandlerInterface
{
    return new Dispatcher(
        $handlers['interceptors'],
        $handlers['middlewares'],
        $handlers['handler'],
        $handlers['decorators']
    );
}
