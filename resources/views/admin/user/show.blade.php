@extends('admin.layout')

@section('content')
    <h1>{{ $user->name }}</h1>
    <ul>
        @foreach ($user->photos as $photo)
            <li>{{ $photo->url }}</li>
        @endforeach
    </ul>
@endsection
