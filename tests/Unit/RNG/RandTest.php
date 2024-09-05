<?php

namespace Tests\Unit\RNG;

use App\RNG\Rand;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RandTest extends TestCase
{
    public function test_we_use_getrandmax_as_upper_bound()
    {
        $rng = new Rand(mt_getrandmax() + 1);

        /**
         * I really want to keep the prop private
         * so lets use reflection to get the actual value.
         */
        $reflector = new ReflectionClass(get_class($rng));
        $prop = $reflector->getProperty('max');
        $prop->setAccessible(true);

        $max = $prop->getValue($rng);
        $prop->setAccessible(false);

        $this->assertEquals(mt_getrandmax(), $max);
    }
}
