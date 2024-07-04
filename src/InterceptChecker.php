<?php

declare(strict_types=1);

namespace Hakone;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class InterceptChecker implements RequestHandlerInterface
{
    /** @var ServerRequestInterface */
    private $request;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->request = $request;

        return NotIntercepted::singleton();
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
