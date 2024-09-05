<?php

namespace App\RNG;

interface RNGSource
{
    public function seed(int $seed): self;

    public function min(int $min): self;

    public function max(int $max): self;

    public function generate(): int;
}
