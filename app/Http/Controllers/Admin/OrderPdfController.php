<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf; // Correct import

class OrderPdfController extends Controller
{
    public function invoice(Order $order)
    {
        $pdf = Pdf::loadView('admin.orders.pdf.invoice', compact('order'));
        return $pdf->download('invoice-'.$order->order_number.'.pdf');
    }

    public function packingSlip(Order $order)
    {
        $pdf = Pdf::loadView('admin.orders.pdf.packing-slip', compact('order'));
        return $pdf->download('packing-slip-'.$order->order_number.'.pdf');
    }
}



