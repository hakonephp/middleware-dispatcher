<?php

declare(strict_types=1);

namespace Hakone\Helper;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestResponseHandler implements RequestHandlerInterface
{
    private $response;

    /** @var ServerRequestInterface */
    public $received_request;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->received_request = $request;

        return $this->response;
    }
}
