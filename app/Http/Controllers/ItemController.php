<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Price;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        return ItemResource::collection(Item::all());
    }

    public function show(Request $request, Item $item): ItemResource
    {
        return new ItemResource($item);
    }

    public function destroy(Request $request, Item $item): JsonResponse
    {
        DB::transaction(function() use ($item) {
            foreach ($item->prices as $price) {
                $price->delete();
            }

            $item->delete();
        });

        return response()->json(['destroyed' => 'ok']);
    }

    public function store(StoreItemRequest $request): RedirectResponse
    {
        $body = $request->validated();

        $item = $body;
        unset($item['prices']);

        DB::transaction(function() use (&$item, $body) {
            $item = Item::create($item);

            foreach ($body['prices'] as $price) {
                $price = Price::create($price);
                $item->prices()->attach($price);
                $price->save();
            }

            $item->save();
        });

        return redirect()->route('items.show', ['item' => $item]);
    }

    /**
     * We can treat update as a replacement
     * for now.
     */
    public function update(StoreItemRequest $request, Item $item): RedirectResponse
    {
        $body = $request->validated();

        DB::transaction(function() use (&$item, $body) {
            foreach (['name', 'description'] as $key) {
                $item->{$key} = $body[$key];
            }

            foreach ($item->prices as $price) {
                $price->delete();
            }

            foreach ($body['prices'] as $price) {
                $price = Price::create($price);
                $item->prices()->attach($price);
                $price->save();
            }

            $item->save();
        });

        return redirect()->route('items.show', ['item' => $item]);
    }
}
