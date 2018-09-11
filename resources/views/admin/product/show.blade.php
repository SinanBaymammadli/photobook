@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                About

                <div>
                    @if(auth()->user()->can("delete-products"))
                        <button type="button" class="btn btn-sm btn-danger" data-product-id="{{ $product->id }}" data-toggle="modal" data-target="#deleteCategoryModal">
                            <i class="far fa-trash-alt"></i>
                            Delete
                        </button>
                    @endif

                    @if(auth()->user()->can("update-products"))
                        <a class="btn btn-sm btn-warning" href="{{ route('product.edit', ['id' => $product->id]) }}">
                            <i class="far fa-edit"></i>
                            Edit
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <p>{{ $product->details }}</p>

                <table class="table" id="product-types-table-js">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Detail</th>
                            <th scope="col">Image</th>
                            <th scope="col">Price</th>
                            <th scope="col">Req. photo count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->types as $type)
                            <tr>
                                <th scope="row">{{ $type->id }}</th>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->detail }}</td>
                                <td>
                                    <img width="50" src="{{ asset($type->img_url) }}">
                                </td>
                                <td>{{ $type->price / 100 }}</td>
                                <td>{{ $type->photo_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('extra')
    @include('admin.product.delete-modal')
@endsection
