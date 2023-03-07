<?php

declare(strict_types=1);

namespace Hakone;

use Hakone\Helper\TestResponseHandler;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * @phpstan-type relay_handlers array{
 *     interceptors: array<Middleware>,
 *     middlewares: array<Middleware>,
 *     handler: TestResponseHandler,
 *     decorators: array<Middleware>
 * }
 * @phpstan-type expected_request array{
 *     method: string,
 *     request_uri: string,
 *     headers: array<string, list<string>>,
 *     body: string
 * }
 * @phpstan-type expected_response array{
 *     status: int,
 *     headers: array<string, list<string>>,
 *     body: string
 * }
 */
class DispatcherTest extends TestCase
{
    /**
     * @dataProvider paremetersProvider
     * @covers Dispatcher
     * @param relay_handlers $handlers
     * @param array{request: expected_request, response: expected_response} $expected
     */
    public function test(array $handlers, array $expected): void
    {
        $factory = new Psr17Factory();
        $subject = new Dispatcher(
            $handlers['interceptors'],
            $handlers['middlewares'],
            $handlers['handler'],
            $handlers['decorators']
        );

        $request = $factory->createServerRequest('GET', '/dummy');
        $actual = $subject->handle($request);

        $this->assertSame($expected['response'], [
            'status' => $actual->getStatusCode(),
            'headers' => $actual->getHeaders(),
            'body' => (string) $actual->getBody(),
        ]);

        $received_request = $handlers['handler']->received_request;

        $this->assertSame($expected['request'], [
            'method' => $received_request->getMethod(),
            'request_uri' => (string) $received_request->getUri(),
            'headers' => $received_request->getHeaders(),
            'body' => (string) $received_request->getBody(),
        ]);
    }

    /**
     * @return iterable<array{handlers: relay_handlers, expected: array{request: expected_request, response: expected_response}}>
     */
    public function paremetersProvider()
    {
        $factory = new Psr17Factory();
        $response = $factory->createResponse();

        $append_request_header = middleware(
            function (ServerRequest $request, RequestHandler $handler): Response {
                return $handler->handle($request->withHeader('Foo', 'Request'));
            }
        );

        $append_response_header = middleware(
            function (ServerRequest $request, RequestHandler $handler): Response {
                return $handler->handle($request)->withHeader('Bar', 'Response');
            }
        );

        yield 'empty parameters' => [
            'handlers' => [
                'interceptors' => [],
                'middlewares' => [],
                'handler' => new TestResponseHandler($response),
                'decorators' => [],
            ],
            'expected' => [
                'request' => [
                    'method' => 'GET',
                    'request_uri' => '/dummy',
                    'headers' => [],
                    'body' => '',
                ],
                'response' => [
                    'status' => 200,
                    'headers' => [],
                    'body' => '',
                ],
            ],
        ];

        yield 'use one append interceptors' => [
            'handlers' => [
                'interceptors' => [$append_request_header],
                'middlewares' => [],
                'handler' => new TestResponseHandler($response),
                'decorators' => [],
            ],
            'expected' => [
                'request' => [
                    'method' => 'GET',
                    'request_uri' => '/dummy',
                    'headers' => [
                        'Foo' => ['Request'],
                    ],
                    'body' => '',
                ],
                'response' => [
                    'status' => 200,
                    'headers' => [],
                    'body' => '',
                ],
            ],
        ];

        yield 'use one append decorator' => [
            'handlers' => [
                'interceptors' => [],
                'middlewares' => [],
                'handler' => new TestResponseHandler($response),
                'decorators' => [$append_response_header],
            ],
            'expected' => [
                'request' => [
                    'method' => 'GET',
                    'request_uri' => '/dummy',
                    'headers' => [],
                    'body' => '',
                ],
                'response' => [
                    'status' => 200,
                    'headers' => [
                        'Bar' => ['Response'],
                    ],
                    'body' => '',
                ],
            ],
        ];

        yield 'use append intersepter and decorator' => [
            'handlers' => [
                'interceptors' => [$append_request_header],
                'middlewares' => [],
                'handler' => new TestResponseHandler($response),
                'decorators' => [$append_response_header],
            ],
            'expected' => [
                'request' => [
                    'method' => 'GET',
                    'request_uri' => '/dummy',
                    'headers' => [
                        'Foo' => ['Request'],
                    ],
                    'body' => '',
                ],
                'response' => [
                    'status' => 200,
                    'headers' => [
                        'Bar' => ['Response'],
                    ],
                    'body' => '',
                ],
            ],
        ];

        yield 'use append interceptor and decorator as middlewares' => [
            'handlers' => [
                'interceptors' => [],
                'middlewares' => [$append_request_header, $append_response_header],
                'handler' => new TestResponseHandler($response),
                'decorators' => [],
            ],
            'expected' => [
                'request' => [
                    'method' => 'GET',
                    'request_uri' => '/dummy',
                    'headers' => [
                        'Foo' => ['Request'],
                    ],
                    'body' => '',
                ],
                'response' => [
                    'status' => 200,
                    'headers' => [
                        'Bar' => ['Response'],
                    ],
                    'body' => '',
                ],
            ],
        ];
    }
}
