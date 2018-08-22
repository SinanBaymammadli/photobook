@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <h1>{{ $user->name }}</h1>
        <a class="btn btn-primary" href="{{ route('photo.downloadByDate', ['id' => $user->id, 'date' => $date]) }}">
            Download Photos in {{ Carbon\Carbon::parse($date)->format('F Y') }}
        </a>
        <div>
            @foreach($photos as $photo)
                <img src="{{ asset($photo->url) }}" width="100" height="100" class="m-2">
            @endforeach
        </div>
    </div>
@endsection
