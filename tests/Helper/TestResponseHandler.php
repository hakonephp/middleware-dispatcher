<?php

declare(strict_types=1);

namespace Hakone\Helper;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestResponseHandler implements RequestHandlerInterface
{
    /** @var ServerRequestInterface */
    public $received_request;

    public function __construct(
        private ResponseInterface $response
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->received_request = $request;

        return $this->response;
    }
}
