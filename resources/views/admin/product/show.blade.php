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
            </div>
        </div>
    </div>
@endsection

@section('extra')
    @include('admin.product.delete-modal')
@endsection
