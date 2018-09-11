@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Order
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
                <a class="btn btn-primary" href="{{ route('photo.downloadByDate', ['id' => $order->user->id, 'date' => $order->created_at->toDateString()]) }}">
                    Download Photos
                </a>
            </div>
            <div class="card-body">
                @foreach($order->photos as $photo)
                    <img src="{{ asset($photo->url) }}" width="100" height="100" class="mb-2 mr-2">
                @endforeach
            </div>
        </div>
    </div>
@endsection
