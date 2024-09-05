<?php

namespace App\RNG;

/**
 * This is a quick little random number
 * generator I've written because:
 *
 * 1. Not all languages will have multiple seedable RNG.
 *    To have two reliably, I'm going to have to make it.
 * 2. It's a nice little demo to show how RNG _can_ work.
 * 3. I wanted two objects sharing an interface to show how
 *    I'd use the dependency injection container.
 *
 * This is NOT to be used for secure random number generation.
 * It doesn't have the randomness.
 *
 * Here are more details on how Linear Congruential Generators work:
 * https://en.wikipedia.org/wiki/Linear_congruential_generator
 */
class LCG implements RNGSource
{
    public function __construct(
        private int $seed = 12345,
        private int $max = 2,
        private int $min = 1,
    ) {
        //^^ All done above
    }

    public function seed(int $seed): self
    {
        $this->seed = $seed;

        return $this;
    }

    public function min(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function max(int $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function generate(): int
    {
        $this->seed = (($this->seed * 1103515245) + 12345) % 2147483648;

        if (
            $this->max < 1
            || $this->max == $this->min
        ) {
            return $this->max;
        }

        return ($this->seed % $this->max) + $this->min;
    }
}
