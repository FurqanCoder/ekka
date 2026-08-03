<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Order\ViewOrder;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_delivering_a_cod_order_marks_payment_paid_and_records_timestamp(): void
    {
        $order = Order::create([
            'customer_name' => 'Test Customer',
            'customer_phone' => '03001234567',
            'shipping_address' => 'Test Address',
            'shipping_city' => 'Karachi',
            'shipping_state' => 'Sindh',
            'shipping_postal_code' => '75000',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'status' => 'pending',
            'invoice_no' => 'INV-1001',
            'subtotal' => 100,
            'grand_total' => 100,
        ]);

        Livewire::test(ViewOrder::class, ['order' => $order])
            ->set('status', 'delivered')
            ->call('updateStatus');

        $order->refresh();

        $this->assertSame('delivered', $order->status);
        $this->assertNotNull($order->delivered_at);
        $this->assertSame('paid', $order->payment_status);
    }
}
