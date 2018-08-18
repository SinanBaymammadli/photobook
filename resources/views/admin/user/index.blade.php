@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <table class="table" id="user-table-js">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Photo count</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->photos->count() }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger">
                                <i class="far fa-trash-alt"></i>Delete
                            </button>
                            <a class="btn btn-sm btn-warning" href="{{ route('user.edit', ['id' => $user->id]) }}">
                                <i class="far fa-edit"></i>Edit
                            </a>
                            <a class="btn btn-sm btn-info" href="{{ route('user.show', ['id' => $user->id]) }}">
                                <i class="far fa-eye"></i>View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
