<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Price;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    private array $fixtures;

    /**
     * First, lets add some items
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->fixtures = json_decode(file_get_contents(__DIR__.'/fixtures/items.json'), true);

        foreach ($this->fixtures as $item) {
            $prices = $item['prices'];
            unset($item['prices']);

            $item = Item::create($item);

            foreach ($prices as $price) {
                $price = Price::create($price);
                $item->prices()->attach($price);
                $price->save();
            }

            $item->save();
        }
    }

    public function test_that_we_can_generate_a_shop_with_rand(): void
    {
        $rng = [
            'method' => 'rand',
            'seed' => 123456,
        ];

        $response = $this->postJson(
            route('shop.generate'),
            [
                'rng' => $rng,
                'price' => [
                    'min' => 4,
                    'max' => 20,
                ],
                'num_items' => 10,
            ],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(200);

        $body = json_decode($response->content(), true);

        $this->assertEquals($rng, $body['rng']);

        $this->assertCount(2, $body['items']);
        $this->assertEquals(
            $this->fixtures[2]['prices'][0]['value'],
            $body['items'][0]['prices'][0]['value']
        );
    }

    public function test_that_we_can_generate_a_shop_with_lcg(): void
    {
        $rng = [
            'method' => 'lcg',
            'seed' => 123456,
        ];

        $response = $this->postJson(
            route('shop.generate'),
            [
                'rng' => $rng,
                'price' => [
                    'min' => 4,
                    'max' => 20,
                ],
                'num_items' => 10,
            ],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        );

        $body = json_decode($response->content(), true);

        $this->assertEquals($rng, $body['rng']);

        $this->assertCount(2, $body['items']);
        $this->assertEquals(
            $this->fixtures[0]['prices'][0]['value'],
            $body['items'][0]['prices'][0]['value']
        );
    }
}
