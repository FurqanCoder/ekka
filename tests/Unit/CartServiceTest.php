<?php

namespace Tests\Unit;

use App\Services\CartService;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    public function test_update_quantity_returns_feedback_for_guest_cart(): void
    {
        $service = app(CartService::class);

        $result = $service->updateQuantity(1, null, 2);

        $this->assertIsArray($result);
        $this->assertSame('success', $result['status']);
        $this->assertSame('Cart updated successfully.', $result['message']);
    }
}
