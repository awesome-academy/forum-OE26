@extends('layouts.app')

@section('content')
    <h2 class="my-5">{{ trans('create.edit') }}</h2>
    <form method="POST" action="{{ route('answers.update', ['answer' => $answerId]) }}"
        content-id="{{ $content->id }}" class="alert alert-dark" id="edit-answer-form">
        @csrf
        @method('PUT')
        <input type="hidden" name="question_id" value="{{ $questionId }}">
        <div class="form-group">
            <label>{{ trans('create.body') }}</label>
            @error ('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-control" id="editor"></div>
        </div>
    </form>
    <button class="btn text-nowrap px-2 bg-color-2 color-4 review-btn" id="edit-answer-submit">
        {{ trans('create.review') }}
    </button>
@endsection
