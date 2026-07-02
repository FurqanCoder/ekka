<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>

<body>

    <div class="header">
        <h2>Packing Slip</h2>
        <p>Order # {{ $order->order_number }} | {{ $order->created_at->format('d M, Y') }}</p>
    </div>

    <h4>Ship To:</h4>
    <p>
        {{ $order->customer_name }} <br>
        {{ $order->customer_phone }} <br>
        {{ $order->customer_address }}
    </p>

    <h4>Items to Pick</h4>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Qty</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
