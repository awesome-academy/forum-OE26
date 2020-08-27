@extends('admin.layouts.app')

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container">
            <div class="row w-100">
                <form action="{{ route('store_tag') }}" method="post" class="w-100">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ trans('admin.name') }}</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description" class="">{{ trans('admin.description') }}</label>
                        <textarea type="text" name="description" id="description" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('admin.create') }}</button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
