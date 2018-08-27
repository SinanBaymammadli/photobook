@extends('admin.layout')

@section('content')
    <div class="container">
        <div id="chart"></div>
        {!! Lava::render('AreaChart', 'Orders', 'chart') !!}
    </div>
@endsection
