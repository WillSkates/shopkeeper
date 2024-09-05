<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::apiResources(
    ['items' => ItemController::class]
);

Route::post('/shop', [ShopController::class, 'generate'])->name('shop.generate');
