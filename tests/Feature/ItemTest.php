<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    private $createResponse;

    private $item;

    /**
     * First, lets add an item.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->item = [
            'name' => 'item',
            'description' => 'description',
            'prices' => [
                [
                    'type' => 'test',
                    'value' => '321321321321',
                ],
            ],
        ];

        $this->createResponse = $this->postJson(
            route('items.store'),
            $this->item,
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        );

        $this->createResponse->assertStatus(302);
    }

    public function test_that_we_can_list_items(): void
    {
        $response = $this->get(route('items.index'));

        $content = json_decode($response->content(), true);
        $this->assertEquals($this->item, $content['data'][0]);
    }

    public function test_that_we_can_add_an_item(): void
    {
        $response = $this->get($this->createResponse->headers->get('location'));

        $content = json_decode($response->content(), true);
        $this->assertEquals($this->item, $content['data']);
    }

    public function test_that_we_can_edit_an_item(): void
    {
        $new = $this->item;
        $new['name'] = 'new item name';

        $response = $this->putJson(
            $this->createResponse->headers->get('location'),
            $new
        );

        $response->assertStatus(302);

        $response = $this->get($response->headers->get('location'));
        $content = json_decode($response->content(), true);
        $this->assertEquals($new, $content['data']);
    }

    public function test_that_we_can_delete_an_item(): void
    {
        $response = $this->delete($this->createResponse->headers->get('location'));

        $response->assertStatus(200);
        $this->assertEquals(
            ['destroyed' => 'ok'],
            json_decode($response->content(), true)
        );

        $response = $this->get($this->createResponse->headers->get('location'));
        $response->assertStatus(404);
    }
}
