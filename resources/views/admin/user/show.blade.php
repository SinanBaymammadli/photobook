@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <h1>{{ $user->name }}</h1>
        <a class="btn btn-primary" href="{{ route('photo.download', ['id' => $user->id]) }}">
            Download All Photos
        </a>
        <div>
            @foreach($photoDates as $photoDate)
                <a class="border p-3 m-2 d-inline-block text-white bg-secondary" href="{{ route('photo.byDate', ['id' => $user->id, 'date' => $photoDate->created_at->toDateString()]) }}">
                    {{ $photoDate->created_at->format('F Y') }}
                </a>
            @endforeach
        </div>
    </div>
@endsection
