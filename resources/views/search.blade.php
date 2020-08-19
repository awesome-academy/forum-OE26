@extends('layouts.app')

@section('content')
    <div class="row justify-content-between flex-nowrap">
        <h2 class="text-break color-1">{{ trans('list.all_questions') }}</h2>
        <form action="{{ route('questions.create') }}" method="get">
            <button type="submit" class="btn text-nowrap px-2 bg-color-2 color-4">
                {{ trans('list.ask_question') }}
            </button>
        </form>
    </div>
    <div class="row justify-content-between pt-3 pb-1 border-bottom">
        <h5 class="align-self-end mb-0">
            {{ $numberOfQuestions . trans('list.questions') }}
        </h5>
        <form action="{{ route('search') }}" id="sorted-options-form" method="get">
            <input type="hidden" name="{{ config('constants.query') }}" value="{{ $query }}" >
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary">
                    @if ($sortedBy === config('constants.newest'))
                        <input type="radio" name="{{ config('constants.sorted_by') }}" value="{{ config('constants.newest') }}" autocomplete="off" checked />
                    @else
                        <input type="radio" name="{{ config('constants.sorted_by') }}" value="{{ config('constants.newest') }}" autocomplete="off" />
                    @endif
                    {{ trans('list.newest') }}
                </label>
                <label class="btn btn-secondary">
                    @if ($sortedBy === config('constants.active'))
                        <input type="radio" name="{{ config('constants.sorted_by') }}" value="{{ config('constants.active') }}" autocomplete="off" checked />
                    @else
                        <input type="radio" name="{{ config('constants.sorted_by') }}" value="{{ config('constants.active') }}" autocomplete="off" />
                    @endif
                    {{ trans('list.active') }}
                </label>
                <label class="btn btn-secondary">
                    @if ($sortedBy === config('constants.unanswered'))
                        <input type="radio" name="{{ config('constants.sorted_by') }}" value="{{ config('constants.unanswered') }}" autocomplete="off" checked />
                    @else
                        <input type="radio" name="{{ config('constants.sorted_by') }}" value="{{ config('constants.unanswered') }}" autocomplete="off" />
                    @endif
                    {{ trans('list.unanswered') }}
                </label>
            </div>
        </form>
    </div>
    @foreach ($questions as $question)
        <div class="row flex-nowrap color-2 border-bottom">
            <div class="d-flex flex-column align-items-center post-left-column-1 pt-3">
                <div class="d-flex flex-column align-items-center mb-1">
                    <h5 class="mb-0 small-text">
                        {{ $question->sum_votes }}
                    </h5>
                    <p class="mb-0 small-text">
                        {{ trans('list.votes') }}
                    </p>
                </div>
                <div class="d-flex flex-column align-items-center alert alert-success bg-color-3 p-2 mb-2">
                    <h5 class="mb-0 mt-1 small-text">
                        {{ $question->answers_count }}
                    </h5>
                    <p class="mb-0 small-text">
                        {{ trans('list.answers') }}
                    </p>
                </div>
                <p class="mb-0 text-nowrap small-text">
                    {{ $question->views_number . trans('list.views') }}
                </p>
            </div>
            <div class="post-right-column flex-grow-1 pl-3 d-flex flex-column">
                <div class="mt-3">
                    <a class="color-2" href="{{ route('questions.show', ['question' => $question->id]) }}">
                        {{ $question->title }}
                    </a>
                </div>
                <div class="d-flex justify-content-between flex-grow-1 pr-3">
                    <div class="d-flex align-items-start flex-wrap w-100">
                        <p class="d-inline-block alert alert-success px-1 py-0 my-0 mr-1">
                            <!-- Content -->
                        </p>
                    </div>
                    <div class="d-flex flex-wrap flex-grow-1 justify-content-end align-self-end">
                        <div class="user-info text-break p-2 mr-2">
                            <p class="small-text m-0">
                                {{ trans('list.answered')}} <span>{{ date('F j, Y', strtotime($question->created_at)) }}</span>
                            </p>
                            <div class="d-flex">
                                <img src="{{ asset('storage/default_avatar.png') }}" class="mr-2 small-avatar" />
                                <p class="small-text m-0">
                                    {{ $question->user->name }}
                                    <br />
                                    {{ $question->user->location }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-end mt-3">
        {{ $questions->links() }}
    </div>
@endsection
