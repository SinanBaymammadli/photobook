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
                Photos
                <a class="btn btn-primary" href="{{ route('album-order.download', ['id' => $order->id]) }}">
                    Download Photos
                </a>
            </div>
            <div class="card-body">
                @foreach($order->photos as $photo)
                    <img src="{{ asset("storage/" . $photo->url) }}" width="300" height="200">
                @endforeach
            </div>
        </div>
    </div>
@endsection
