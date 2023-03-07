<?php

declare(strict_types=1);

namespace Hakone;

use BadMethodCallException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class NotIntercepted implements ResponseInterface
{
    /**
     * @var ?self
     */
    private static $singleton;

    private function __construct()
    {
    }

    public static function singleton(): self
    {
        if (self::$singleton === null) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }

    public function getProtocolVersion()
    {
        throw new BadMethodCallException();
    }

    public function withProtocolVersion($version)
    {
        throw new BadMethodCallException();
    }

    public function getHeaders()
    {
        throw new BadMethodCallException();
    }

    public function hasHeader($name)
    {
        throw new BadMethodCallException();
    }

    public function getHeader($name)
    {
        throw new BadMethodCallException();
    }

    public function getHeaderLine($name)
    {
        throw new BadMethodCallException();
    }

    public function withHeader($name, $value)
    {
        throw new BadMethodCallException();
    }

    public function withAddedHeader($name, $value)
    {
        throw new BadMethodCallException();
    }

    public function withoutHeader($name)
    {
        throw new BadMethodCallException();
    }

    public function getBody()
    {
        throw new BadMethodCallException();
    }

    public function withBody(StreamInterface $body)
    {
        throw new BadMethodCallException();
    }

    public function getStatusCode()
    {
        throw new BadMethodCallException();
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        throw new BadMethodCallException();
    }

    public function getReasonPhrase()
    {
        throw new BadMethodCallException();
    }
}
