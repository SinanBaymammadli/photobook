@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    {{ $user->name }}
                </span>

                <a class="btn btn-primary" href="{{ route('photo.downloadByDate', ['id' => $user->id, 'date' => $date]) }}">
                    Download Photos in {{ Carbon\Carbon::parse($date)->format('F Y') }}
                </a>
            </div>
            <div class="card-body">
                @foreach($photos as $photo)
                    <img src="{{ asset($photo->url) }}" width="100" height="100" class="mb-2 mr-2">
                @endforeach
            </div>
        </div>
    </div>
@endsection
