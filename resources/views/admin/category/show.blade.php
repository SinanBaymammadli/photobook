@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                About

                <div>
                    @if(auth()->user()->can("delete-categories"))
                        <button type="button" class="btn btn-sm btn-danger" data-category-id="{{ $category->id }}" data-toggle="modal" data-target="#deleteCategoryModal">
                            <i class="far fa-trash-alt"></i>
                            Delete
                        </button>
                    @endif

                    @if(auth()->user()->can("update-categories"))
                        <a class="btn btn-sm btn-warning" href="{{ route('category.edit', ['id' => $category->id]) }}">
                            <i class="far fa-edit"></i>
                            Edit
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <h1>{{ $category->name }}</h1>

                <img  height="100" src="{{ asset($category->img_url) }}" alt="">
            </div>
        </div>
    </div>
@endsection

@section('extra')
    @include('admin.category.delete-modal')
@endsection
