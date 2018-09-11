@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-0">Products</h4>

                @if(auth()->user()->can("create-products"))
                    <a class="btn btn-success" href="{{ route('product.create') }}">
                        <i class="fas fa-plus"></i>
                        Add new
                    </a>
                @endif
            </div>
            <div class="card-body">
                <table class="table" id="product-table-js">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ route('product.edit', ['id' => $product->id]) }}">
                                        <i class="far fa-edit"></i>
                                        Edit
                                    </a>
                                    <a class="btn btn-sm btn-info" href="{{ route('product.show', ['id' => $product->id]) }}">
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
    @include('admin.product.delete-modal')
@endsection
