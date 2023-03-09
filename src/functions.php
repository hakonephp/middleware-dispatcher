<?php

declare(strict_types=1);

namespace Hakone;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
function relay(array $handlers): Dispatcher
{
    return new Dispatcher(
        new RequestInterceptor($handlers['interceptors']),
        $handlers['middlewares'],
        $handlers['handler'],
        $handlers['decorators']
    );
}

/**
 * @param array<MiddlewareInterface> $interceptors
 * @return array{ServerRequestInterface, ?ResponseInterface}
 */
function filter_request(array $interceptors, ServerRequestInterface $request): array
{
    return (new RequestInterceptor($interceptors))->interceptRequest($request);
}
