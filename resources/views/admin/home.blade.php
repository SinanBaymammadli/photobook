@extends('admin.layout')

@section('content')
    <div class="container">
        <div id="chart"></div>
        {!! Lava::render('AreaChart', 'Population', 'chart') !!}
    </div>
@endsection
