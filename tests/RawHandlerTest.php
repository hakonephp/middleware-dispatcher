<?php

declare(strict_types=1);

namespace Hakone;

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ResponseHandler::class)]
class RawHandlerTest extends TestCase
{
    public function test(): void
    {
        $factory = new Psr17Factory();
        $response = $factory->createResponse();
        $subject = new ResponseHandler($response);
        $request = $factory->createServerRequest('GET', '/dummy');

        self::assertSame($response, $subject->handle($request));
    }
}
