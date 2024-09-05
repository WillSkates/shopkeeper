<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ItemResource;
use App\Models\Price;
use App\RNG;
use Illuminate\Http\JsonResponse;

class ShopController extends Controller
{
    public function generate(ShopRequest $request): JsonResponse
    {
        $data = $request->validated();

        $rng = app()->makeWith(RNG\RNGSource::class, $data['rng']);

        $prices = Price::valueBetween(
            $data['price']['min'],
            $data['price']['max']
        )->get()->all();

        $len = count($prices);
        $items = [];

        while ($len > 0) {
            $len--;
            $keys = array_keys($prices);

            $keyNum = $rng->min(0)->max($len)->generate();
            $items[] = $prices[$keys[$keyNum]]->items[0];
        }

        return response()->json(
            [
                'name' => 'Example Shop',
                'rng' => [
                    'method' => $data['rng']['method'],
                    'seed' => $data['rng']['seed'],
                ],
                'items' => ItemResource::collection($items),
            ]
        );
    }
}
