<?php

namespace App\Livewire\Web\Dashboard;

use App\Models\Order;
use Livewire\Component;

class OrderDetailComponent extends Component
{
    public $order;

    public function mount($invoice)
    {
        $this->order = Order::with(['items.product', 'items.variant'])
            ->where('invoice_no', $invoice)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    }

    /**
     * Get status badge color
     */
    public function getStatusBadge($status)
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'completed' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary',
        ];
        return $colors[$status] ?? 'secondary';
    }

    /**
     * Get payment method label
     */
    public function getPaymentMethodLabel($method)
    {
        $methods = [
            'cod' => 'Cash on Delivery',
            'card' => 'Credit/Debit Card',
            'bank' => 'Bank Transfer',
            'easy_paisa' => 'EasyPaisa / JazzCash',
            'paypal' => 'PayPal',
            'stripe' => 'Stripe',
        ];
        return $methods[$method] ?? ucfirst($method);
    }

    /**
     * Cancel order
     */
    public function cancelOrder()
    {
        if (!in_array($this->order->status, ['pending', 'processing'])) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'This order cannot be cancelled.']);
            return;
        }

        $this->order->update(['status' => 'cancelled']);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Order cancelled successfully!']);
        
        // Refresh order data
        $this->order->refresh();
    }

    public function render()
    {
        return view('livewire.web.dashboard.order-detail-component')
            ->extends('layouts.web')
            ->section('web-content');
    }
}