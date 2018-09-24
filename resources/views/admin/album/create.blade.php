@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Create new product</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('product.store') }}" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="product_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="product_name" type="text" class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }}"
                                name="product_name" required autofocus value="Ramka">

                            @if($errors->has('product_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                        <div class="col-md-6">
                            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                name="description" required>Lorem</textarea>

                            @if($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="details" class="col-md-4 col-form-label text-md-right">Details</label>

                        <div class="col-md-6">
                            <textarea id="details" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}"
                                name="details" required>Lorem</textarea>

                            @if($errors->has('details'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('details') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="category_id" class="col-md-4 col-form-label text-md-right">Category</label>

                        <div class="col-md-6">
                            <select class="custom-select form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @if($errors->has('category_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="photos" class="col-md-4 col-form-label text-md-right d-flex align-items-center justify-content-end">Photos</label>

                        <div class="col-md-6 d-flex align-items-center">
                            <input id="photos" type="file" class="{{ $errors->has('photos') ? ' is-invalid' : '' }}"
                                name="photos[]" multiple>

                            @if($errors->has('photos'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('photos') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- React element --}}
                    <div id="product-type-create-form"></div>
                    {{-- React element --}}

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
