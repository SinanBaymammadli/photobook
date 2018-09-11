@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-0">Catagories</h4>

                @if(auth()->user()->can("create-categories"))
                    <a class="btn btn-success" href="{{ route('category.create') }}">
                        <i class="fas fa-plus"></i>
                        Add new
                    </a>
                @endif
            </div>
            <div class="card-body">
                <table class="table" id="category-table-js">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <th scope="row">{{ $category->id }}</th>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <img  height="30" src="{{ asset($category->img_url) }}" alt="">
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ route('category.edit', ['id' => $category->id]) }}">
                                        <i class="far fa-edit"></i>
                                        Edit
                                    </a>
                                    <a class="btn btn-sm btn-info" href="{{ route('category.show', ['id' => $category->id]) }}">
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
    @include('admin.category.delete-modal')
@endsection
