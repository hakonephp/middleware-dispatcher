# Hakone PSR-15 middleware dispatcher 🏃‍♀️

[![Package version](https://img.shields.io/packagist/v/hakone/middleware-dispatcher.svg?style=flat)](https://packagist.org/packages/hakone/middleware-dispatcher)
[![Build Status](https://github.com/hakonephp/middleware-dispatcher/actions/workflows/test.yml/badge.svg?branch=master)](https://github.com/hakonephp/middleware-dispatcher/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/hakone/middleware-dispatcher.svg)](https://packagist.org/packages/hakone/middleware-dispatcher)

**Hakone** is a lightweight [PSR-15] middleware dispatcher implementation. It is inspired by [Relay].

It splits the pipeline into request interceptors, general-purpose middleware, and response decorators.

## Install

```
composer require hakone/middleware-dispatcher
```

## Concept

The PSR-15 is designed to be general purpose middleware. All middleware can intervene in both requests and responses.

Hakone is a "queue-based request handler" described in [PSR-15 Meta Document]. The downside of queue-based is that the more middleware you have, the more stack traces will pile up.

We've written a number of small-duty middlewares, but for many use cases they only do work on either the request or the response. We decided to classify the types of middleware into three types: **"request interceptor"**, **"general-purpose middleware"** and **"response decorator"**.

## Usage

```php
$dispatcher = Hakone\relay([
    'interceptors' => [
        // ...
    ],
    'middlewares' => [
        // ...
    ],
    'handler' => $handler
    'decorators' => [
        // ...
    ],
]);
```

## Copyright

```
Copyright 2023 USAMI Kenta <tadsan@zonu.me>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```

[PSR-15]: https://www.php-fig.org/psr/psr-15/
[PSR-15 Meta Document]: https://www.php-fig.org/psr/psr-15/meta/
[Relay]: https://relayphp.com/
