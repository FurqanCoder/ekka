<div>
    <div>
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">

                {{-- @include('web.user.sidebar') user dashboard sidebar --}}

                <div class="col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card">
                        <div class="ec-vendor-card-header">
                            <h5>Your Orders</h5>
                        </div>

                        <div class="ec-vendor-card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>#{{ $order->invoice_no }}</td>
                                                <td>{{ $order->created_at->format('d M, Y') }}</td>
                                                <td>{{ "RS." .$order->grand_total }}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($order->status == 'pending') bg-warning
                                                        @elseif($order->status == 'confirmed') bg-info
                                                        @elseif($order->status == 'shipped') bg-primary
                                                        @elseif($order->status == 'delivered') bg-success
                                                        @elseif($order->status == 'cancelled') bg-danger
                                                        @endif
                                                    ">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.orders.show', $order->id) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    No orders found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {{ $orders->links() }}
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
