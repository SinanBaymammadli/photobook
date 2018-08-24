@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Edit user</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('user.update', ['user' => $user]) }}"
                    aria-label="{{ __('Register') }}" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    @method("patch")

                    <div class="form-group row">
                        <label for="avatar" class="col-md-4 col-form-label text-md-right d-flex align-items-center justify-content-end">Avatar</label>

                        <div class="col-md-6 d-flex align-items-center">
                            <img class="mr-3" width="100" height="100" src="{{ asset($user->avatar) }}" alt="">
                            <input id="avatar" type="file" class="{{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                                name="avatar">

                            @if($errors->has('avatar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                name="name" value="{{ $user->name }}" required autofocus>

                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="email" value="{{ $user->email }}" required>

                            @if($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>

                        <div class="col-md-6">
                            <select class="custom-select form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == $user->roles[0]->id ? "selected" : null }}>{{ $role->display_name }}</option>
                                @endforeach
                            </select>

                            @if($errors->has('role'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">
                            {{ __('Password') }}
                        </label>

                        <div class="col-md-6">
                            <input id="password" type="password" placeholder="Leave empty to keep the same" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                name="password">

                            @if($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
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
