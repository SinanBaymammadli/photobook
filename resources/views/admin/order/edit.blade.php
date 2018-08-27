@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Edit order</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('order.update', ['order' => $order]) }}"
                    aria-label="Order Edit">
                    @csrf
                    @method("patch")

                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right">Status</label>

                        <div class="col-md-6">
                            <select class="custom-select form-control" name="status_id">
                                @foreach($order_statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $order->status_id ? "selected" : null }}>{{ $status->display_name }}</option>
                                @endforeach
                            </select>
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
