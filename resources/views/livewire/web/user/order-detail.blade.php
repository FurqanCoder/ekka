<div>
    <div>
        <section class="ec-page-content section-space-p">
            <div class="container">
                <div class="row">

                    {{-- @include('web.user.sidebar') --}}

                    <div class="col-lg-9 col-md-12">
                        <div class="ec-vendor-dashboard-card">

                            <!-- Header -->
                            <div class="ec-vendor-card-header d-flex justify-content-between">
                                <h5>Order Details</h5>
                                <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-primary btn-sm">
                                    Download Invoice
                                </a>
                            </div>

                            <div class="ec-vendor-card-body">

                                <!-- Order Info -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <h6>Order Number:</h6>
                                        <p>#{{ $order->invoice_no }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Order Date:</h6>
                                        <p>{{ $order->created_at->format('d M, Y') }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Status:</h6>
                                        <span
                                            class="badge
                                        @if ($order->status == 'pending') bg-warning
                                        @elseif($order->status == 'confirmed') bg-info
                                        @elseif($order->status == 'shipped') bg-primary
                                        @elseif($order->status == 'delivered') bg-success @endif
                                    ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Timeline -->
                                {{-- <div class="order-tracking mb-4">
                                    <div class="steps d-flex">
                                        @php
                                            $steps = ['pending', 'confirmed', 'shipped', 'delivered'];
                                        @endphp

                                        @foreach ($steps as $step)
                                            <div
                                                class="step {{ in_array($step, array_slice($steps, 0, array_search($order->status, $steps) + 1)) ? 'active' : '' }}">
                                                <span>{{ ucfirst($step) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div> --}}

                                <!-- Items Table -->
                                <div class="table-responsive mb-4">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            {{-- <img src="{{ $item->product->media[file_path] }}"
                                                                style="width: 60px; height: 60px; object-fit: cover"
                                                                class="me-2"> --}}

                                                            {{ $item->product->name }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ "Rs".$item->price }}</td>
                                                    <td>{{ "Rs" .$item->price * $item->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Price Summary -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6>Shipping Address</h6>
                                        <p>
                                            {{ $order->customer_name }} <br>
                                            {{ $order->customer_email }} <br>
                                            {{ $order->customer_phone }} <br>
                                            {{ $order->shipping_city }}, {{ $order->shipping_state }}, {{$order->country}}.
                                        </p>
                                    </div>

                                    <div class="col-md-6">
                                        <h6>Price Summary</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Subtotal:</td>
                                                <td class="text-end">{{ "Rs" .$order->subtotal }}</td>
                                            </tr>
                                            @if ($order->discount_amount > 0)
                                                <tr>
                                                    <td>Discount:</td>
                                                    <td class="text-end">- {{ "Rs" .$order->discount_amount }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Shipping:</td>
                                                <td class="text-end">{{ "Rs" .$order->shipping_charges }}</td>
                                            </tr>
                                            <tr class="fw-bold">
                                                <td>Total:</td>
                                                <td class="text-end">{{ "Rs".$order->grand_total }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

</div>
