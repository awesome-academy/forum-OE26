@extends('admin.layouts.app')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <div id="chart" class="chart" data-url="{{ route('charts.user_chart') }}"></div>
            </div>
        </main>
    </div>
@endsection
