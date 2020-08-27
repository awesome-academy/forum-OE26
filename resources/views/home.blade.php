@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row w-100">
            <form class="w-100" action="{{ route('profile') }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="profile-name">{{ trans('home.name') }}</label>
                    <input type="text" class="form-control" id="profile-name" name="name" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="profile-name">{{ trans('home.location') }}</label>
                    <input type="text" class="form-control" id="profile-name" name="location" value="{{ $user->location }}">
                </div>
                <div class="form-group">
                    <label for="profile-name">{{ trans('home.description') }}</label>
                    <input type="text" class="form-control" id="profile-name" name="title" value="{{ $user->title }}">
                </div>
                <div class="form-group">
                    <label for="profile-name">{{ trans('home.update') }}</label>
                    <textarea class="form-control" id="profile-name" name="description">{{ $user->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">{{ trans('home.update') }}</button>
            </form>
        </div>
        @can('dashboard', Auth::user())
            <div class="row w-100 mt-3">
                <a href="{{ route('admin') }}">{{ trans('home.admin') }}</a>
            </div>
        @endcan
    </div>
@endsection
