@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                User
            </div>
            <div class="card-body">
                <div class="media">
                    <img class="mr-3" src="{{ asset($order->user->avatar) }}" width="100" height="100" />
                    <div class="media-body">
                        <h5 class="card-title">{{ $order->user->name }}</h5>
                        <h6 class="card-subtitle mb-4 text-muted">{{ $order->user->email }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                Items
                {{-- <a class="btn btn-primary" href="{{ route('photo.downloadByDate', ['id' => $order->user->id, 'date' => $order->created_at->toDateString()]) }}">
                    Download Photos
                </a> --}}
            </div>
            <div class="card-body">
                <table class="table" id="order-item-table-js">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Product type</th>
                            <th scope="col">Price</th>
                            <th scope="col">Count</th>
                            <th scope="col">Total</th>
                            <th scope="col">Photos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_price = 0;
                        @endphp
                        @foreach($order->items as $item)
                            @php
                                $item_price = $item->product_type->price / 100;
                                $current_price = $item_price * $item->count;
                                $total_price += $current_price;
                            @endphp
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>{{ $item->product_type->product->name }}</td>
                                <td>{{ $item->product_type->name }}</td>
                                <td>{{ $item_price }} kr</td>
                                <td>{{ $item->count }}</td>
                                <td>{{ $current_price }} kr</td>
                                <td>{{ $item->photos->count() }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="6" class="text-center">Total: {{ $total_price }} kr</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
