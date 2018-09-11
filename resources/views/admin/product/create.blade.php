@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Create new category</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('category.store') }}" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="img" class="col-md-4 col-form-label text-md-right d-flex align-items-center justify-content-end">Image</label>

                        <div class="col-md-6 d-flex align-items-center">
                            <input id="img" type="file" class="{{ $errors->has('img') ? ' is-invalid' : '' }}"
                                name="img">

                            @if($errors->has('img'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('img') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                name="name" required autofocus>

                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

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
