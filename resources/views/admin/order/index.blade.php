@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-0">Orders</h4>
            </div>
            <div class="card-body">
                <table class="table" id="user-table-js">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User name</th>
                            <th scope="col">User email</th>
                            <th scope="col">Order created</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                            <th scope="col">Photos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <th scope="row">{{ $order->id }}</th>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->user->email }}</td>
                                <td>{{ Carbon\Carbon::parse($order->created_at)->format('F Y') }}</td>
                                <td>
                                    @if($order->status->id == 1)
                                        <span class="badge badge-primary">{{ $order->status->display_name }}</span>
                                    @endif
                                    @if($order->status->id == 2)
                                        <span class="badge badge-warning">{{ $order->status->display_name }}</span>
                                    @endif
                                    @if($order->status->id == 3)
                                        <span class="badge badge-info">{{ $order->status->display_name }}</span>
                                    @endif
                                    @if($order->status->id == 4)
                                        <span class="badge badge-success">{{ $order->status->display_name }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                        <i class="far fa-edit"></i>
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('photo.downloadByDate', ['id' => $order->user->id, 'date' => $order->created_at->toDateString()]) }}">
                                        Download Photos
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
