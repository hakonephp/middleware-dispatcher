<?php

declare(strict_types=1);

namespace Hakone;

use Hakone\Http\Message\UntouchableResponse;

final class NotIntercepted extends UntouchableResponse
{
    /** @var ?self */
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
}
