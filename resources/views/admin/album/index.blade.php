@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-0">Products</h4>

                @if(auth()->user()->can("create-albums"))
                    <a class="btn btn-success" href="{{ route('album.create') }}">
                        <i class="fas fa-plus"></i>
                        Add new
                    </a>
                @endif
            </div>
            <div class="card-body">
                <table class="table" id="album-table-js">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Min photo</th>
                            <th scope="col">Max photo</th>
                            <th scope="col">Monthly price</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($albums as $album)
                            <tr>
                                <th scope="row">{{ $album->id }}</th>
                                <td>{{ $album->name }}</td>
                                <td>{{ $album->min_photo_count }}</td>
                                <td>{{ $album->max_photo_count }}</td>
                                <td>{{ $album->monthly_price / 100 }} kr</td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ route('album.edit', ['id' => $album->id]) }}">
                                        <i class="far fa-edit"></i>
                                        Edit
                                    </a>
                                    <a class="btn btn-sm btn-info" href="{{ route('album.show', ['id' => $album->id]) }}">
                                        <i class="far fa-eye"></i>
                                        View
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


@section('extra')
    @include('admin.album.delete-modal')
@endsection
