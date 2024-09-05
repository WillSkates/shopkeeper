<?php

namespace Tests\Unit\Providers;

use App\Providers\RNGServiceProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RNGServiceProviderTest extends TestCase
{
    public function test_we_must_use_a_valid_rng_method(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            '"im_not_valid" is not a valid rng method. Please use one of: "lcg, rand".'
        );
        $provider = new RNGServiceProvider(app());
        $provider->buildRNGSource('im_not_valid', 1);
    }
}
