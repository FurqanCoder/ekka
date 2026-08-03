<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\OfferComponent;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OfferComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_offer_requires_a_selection_when_type_is_product(): void
    {
        Livewire::test(OfferComponent::class)
            ->set('title', 'Summer Sale')
            ->set('type', 'product')
            ->set('discount_type', 'percentage')
            ->set('discount_value', 10)
            ->call('store')
            ->assertHasErrors(['applies_to']);

        $this->assertDatabaseCount('offers', 0);
    }

    public function test_product_type_loads_available_products_for_selection(): void
    {
        Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'status' => 'live',
            'stock' => 10,
            'sku' => 'TEST-001',
        ]);

        $component = Livewire::test(OfferComponent::class)
            ->set('type', 'product');

        $this->assertNotEmpty($component->get('options'));
        $this->assertSame('Test Product', $component->get('options')[0]['label']);
    }
}
