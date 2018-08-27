@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                About
            </div>
            <div class="card-body">
                <div class="media">
                    <img class="mr-3" src="{{ asset($user->avatar) }}" width="100" height="100" />
                    <div class="media-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <h6 class="card-subtitle mb-4 text-muted">{{ $user->email }}</h6>

                        @if(auth()->user()->can("delete-users"))
                            <button type="button" class="btn btn-sm btn-danger" data-user-id="{{ $user->id }}" data-toggle="modal" data-target="#deleteUserModal">
                                <i class="far fa-trash-alt"></i>Delete
                            </button>
                        @endif

                        @if(auth()->user()->can("update-users"))
                            <a class="btn btn-sm btn-warning" href="{{ route('user.edit', ['id' => $user->id]) }}">
                                <i class="far fa-edit"></i>Edit
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    Photos
                </span>
            </div>
            <div class="card-body">
                @foreach($photoDates as $photoDate)
                    <a class="border p-3 m-2 d-inline-block text-white bg-secondary" href="{{ route('photo.byDate', ['id' => $user->id, 'date' => $photoDate->created_at->toDateString()]) }}">
                        {{ $photoDate->created_at->format('F Y') }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('extra')
    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('user.destroy', ['id' => 0]) }}" method="post"
                        id="deleteUserForm">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
