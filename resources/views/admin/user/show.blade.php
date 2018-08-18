@extends('admin.layout')

@section('content')
    <h1>{{ $user->name }}</h1>
    <a class="btn btn-primary" href="{{ route('photo.download', ['id' => $user->id]) }}">
        Download All Photos
    </a>
    <ul>
        @foreach ($user->photos as $photo)
            <li>{{ $photo->url }}</li>
        @endforeach
    </ul>
@endsection
