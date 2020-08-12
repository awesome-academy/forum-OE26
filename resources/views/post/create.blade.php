@extends('layouts.app')

@section('content')
    <h2 class="my-5">{{ trans('create.ask') }}</h2>
    <form method="POST" action="{{ route('questions.store') }}" class="alert alert-dark" id="new-question-form">
        @csrf
        <div class="form-group">
            <label>{{ trans('create.title') }}</label>
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                {{ trans('create.title_description') }}
            </small>
            <input class="form-control" type="text" name="title">
        </div>
        <div class="form-group">
            <label>{{ trans('create.body') }}</label>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                {{ trans('create.body_description') }}
            </small>
            <div class="form-control" id="editor"></div>
        </div>
    </form>
    <button class="btn text-nowrap px-2 bg-color-2 color-4 review-btn" id="new-question-submit">
        {{ trans('create.review') }}
    </button>
@endsection
