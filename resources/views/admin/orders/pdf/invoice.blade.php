<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 25px;
        }

        h2, h3, h4 {
            margin: 5px 0;
            padding: 0;
            font-weight: 600;
        }

        .invoice-header {
            width: 100%;
            margin-bottom: 30px;
        }

        .invoice-header .left {
            float: left;
            width: 55%;
        }

        .invoice-header .right {
            float: right;
            width: 40%;
            text-align: right;
        }

        .divider {
            border-bottom: 1px solid #d7d7d7;
            margin: 20px 0;
        }

        /* TABLE STYLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            background: #f2f2f2;
            font-weight: 600;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .summary-table td {
            padding: 6px 4px;
            font-size: 12px;
        }

        .summary-table tr td:last-child {
            text-align: right;
            width: 120px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }

        .clear { clear: both; }

        .section-title {
            background: #f8f8f8;
            padding: 6px;
            font-weight: 600;
            border-left: 3px solid #0d6efd;
            margin-bottom: 6px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="invoice-header">
        <div class="left">
            <h2 style="font-size: 22px;">INVOICE</h2>
            <p><strong>Order #:</strong> {{ $order->order_number }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>
        </div>

        <div class="right">
            <strong style="font-size: 16px;">{{ config('app.name') }}</strong><br>
            {{ $order->store_address ?? 'Store Address Here' }}<br>
            Phone: {{ $order->store_phone ?? 'Phone Number' }}
        </div>

        <div class="clear"></div>
    </div>

    <div class="divider"></div>

    <!-- BILLING SECTION -->
    <div class="section-title">Billing Details</div>
    <p>
        <strong>{{ $order->customer_name }}</strong> <br>
        {{ $order->customer_phone }} <br>
        {{ $order->customer_address }}
    </p>

    <!-- ITEMS SECTION -->
    <div class="section-title">Order Items</div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 45%;">Product</th>
                <th style="width: 10%;">Qty</th>
                <th style="width: 20%;">Unit Price</th>
                <th style="width: 20%;">Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- SUMMARY SECTION -->
    <table class="summary-table" style="margin-top: 20px;">
        <tr>
            <td style="text-align: right; width: 80%;">Subtotal:</td>
            <td>{{ number_format($order->subtotal, 2) }}</td>
        </tr>

        @if ($order->discount)
        <tr>
            <td style="text-align: right;">Discount:</td>
            <td>-{{ number_format($order->discount, 2) }}</td>
        </tr>
        @endif

        @if ($order->shipping)
        <tr>
            <td style="text-align: right;">Shipping Charges:</td>
            <td>{{ number_format($order->shipping, 2) }}</td>
        </tr>
        @endif

        <tr>
            <td style="text-align: right; font-weight: 700;">Grand Total:</td>
            <td style="font-weight: 700;">{{ number_format($order->grand_total, 2) }}</td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for shopping with {{ config('app.name') }}.  
        We appreciate your business.
    </div>

</body>
</html>
