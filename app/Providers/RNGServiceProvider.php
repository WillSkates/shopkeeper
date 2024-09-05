<?php

namespace App\Providers;

use App\RNG\LCG;
use App\RNG\Rand;
use App\RNG\RNGSource;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class RNGServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            RNGSource::class,
            function (Application $app, array $parameters): RNGSource {
                return $this->buildRNGSource(
                    $parameters['method'],
                    $parameters['seed']
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    //Separate method just to use type hinting
    public function buildRNGSource(string $method, int $seed): RNGSource
    {
        $rng = match ($method) {
            'lcg' => new LCG(),
            'rand' => new Rand(),
            default => null
        };

        if ($rng === null) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid rng method. Please use one of: "%s".',
                    $method,
                    implode(', ', ['lcg', 'rand'])
                )
            );
        }

        return $rng->seed($seed);
    }
}
