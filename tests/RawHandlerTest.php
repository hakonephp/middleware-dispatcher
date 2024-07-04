<?php

declare(strict_types=1);

namespace Hakone;

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

class RawHandlerTest extends TestCase
{
    /** @covers RawHandler */
    public function test(): void
    {
        $factory = new Psr17Factory();
        $response = $factory->createResponse();
        $subject = new ResponseHandler($response);
        $request = $factory->createServerRequest('GET', '/dummy');

        $this->assertSame($response, $subject->handle($request));
    }
}
