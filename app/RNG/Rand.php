<?php

namespace App\RNG;

class Rand implements RNGSource
{
    public function __construct(
        private int $max = 2,
        private int $min = 1
    ) {
        //^^ All done above
        $this->max($this->max);
    }

    public function seed(int $seed): self
    {
        mt_srand($seed);

        return $this;
    }

    public function min(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function max(int $max): self
    {
        if ($max > mt_getrandmax()) {
            $max = mt_getrandmax();
        }

        $this->max = $max;

        return $this;
    }

    public function generate(): int
    {
        if ($this->min == $this->max) {
            return $this->min;
        }

        return mt_rand($this->min, $this->max);
    }
}
