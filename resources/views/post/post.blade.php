@extends('layouts.app')

@section('content')
    <div class="row justify-content-between flex-nowrap">
        <h2 class="text-break color-1">
            {{ $title }}
        </h2>
        <form action="{{ route('questions.create') }}" method="get">
            <button type="submit" class="btn text-nowrap px-2 bg-color-2 color-4">
                {{ trans('post.ask_question') }}
            </button>
        </form>
    </div>
    <div class="row border-bottom flex-nowrap">
        <p class="pr-1 text-secondary small-text">{{ trans('post.asked') }}</p>
        <p class="pr-2 small-text">
            @foreach ($asked as $key => $value)
                @if ($value > 0)
                    @switch($key)
                        @case('y')
                            {{ $value . trans('post.years') }}
                            @break
                        @case('m')
                            {{ $value . trans('post.months') }}
                            @break
                        @case('d')
                            {{ $value . trans('post.days') }}
                            @break
                        @case('h')
                            {{ $value . trans('post.hours') }}
                            @break
                        @case('i')
                            {{ $value . trans('post.minutes') }}
                            @break
                        @default
                            {{ $value . trans('post.seconds') }}
                    @endswitch
                @endif
            @endforeach
            {{ trans('post.ago') }}
        </p>
        <p class="pr-1 text-secondary small-text">{{ trans('post.active') }}</p>
        <p class="pr-2 small-text">
            {{ $activesNumber }}
        </p>
        <p class="pr-1 text-secondary small-text">{{ trans('post.viewed') }}</p>
        <p class="small-text">
            {{ $viewsNumber . trans('post.times') }}
        </p>
    </div>
    <div class="row flex-nowrap mt-3 color-2 border border-dark rounded p-3">
        <div class="d-flex flex-column align-items-center post-left-column">
            @if (isset($vote) && $vote->vote === config('constants.up_vote'))
                <i class="fa fa-caret-up fa-6x hover color-3 up-vote" aria-hidden="true" data-question="{{ $questionId }}"></i>
            @else
                <i class="fa fa-caret-up fa-6x hover up-vote" aria-hidden="true" data-question="{{ $questionId }}"></i>
            @endif
            <h5>{{ $votesNumber }}</h5>
            @if (isset($vote) && $vote->vote === config('constants.down_vote'))
                <i class="fa fa-caret-down fa-6x hover color-3 down-vote" aria-hidden="true" data-question="{{ $questionId }}"></i>
            @else
                <i class="fa fa-caret-down fa-6x hover down-vote" aria-hidden="true" data-question="{{ $questionId }}"></i>
            @endif
            <i class="fa fa-history mt-3 hover" aria-hidden="true"></i>
        </div>
        <div class="post-right-column flex-grow-1 pt-2 pl-3">
            <p>
                @if ($content)
                    <div class="viewer" content-id="{{ $content->id }}"></div>
                @endif
            </p>
            <div class="d-flex flex-wrap w-100 mb-4">
                <p class="d-inline-block alert alert-success px-1 py-0 mt-1 mb-0 mr-1">
                    <!-- Content -->
                </p>
            </div>
            <div class="d-flex justify-content-between pr-3">
                <div class="d-flex flex-nowrap">
                    <a href="#" class="pr-2 small-text share-btn">{{ trans('post.share') }}</a>
                    @can('update', $question)
                        <a href="{{ route('questions.edit', ['question' => $questionId]) }}" class="pr-2 small-text">{{ trans('post.edit') }}</a>
                    @endcan
                </div>
                <div class="d-flex flex-wrap flex-grow-1 justify-content-end">
                    <div class="user-info text-break alert alert-success p-2 mr-2">
                        <p class="small-text m-0">
                            {{ trans('post._asked') }} <span>{{ date('F j, Y', strtotime($content->created_at)) }}</span>
                        </p>
                        <div class="d-flex">
                            <img src="{{ asset('storage/default_avatar.png') }}" alt="{{ trans('post.avatar') }}" class="mr-2 small-avatar" />
                            <p class="small-text m-0">
                                {{ $user->name }}
                                <br />
                                {{ $user->location }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column border-top">
                <div class="modal fade" id="updateCommentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('post.edit_comment') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="update-comment" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="question_id" value="{{ $questionId }}">
                                    <div class="form-group">
                                        <label for="comment-content-input" class="col-form-label">{{ trans('post.comment') }}</label>
                                        <input type="text" class="form-control" name="content" id="comment-content-input">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('post.close') }}</button>
                                <button type="submit" form="update-comment" class="btn btn-primary">{{ trans('post.edit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($comments as $comment)
                    <div>
                        @can('delete', $comment)
                            <form class="delete-comment-form" action="{{ route('comments.destroy', $comment->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="question_id" value="{{ $questionId }}">
                            </form>
                        @endcan
                        <p class="m-0 pl-3 text-break border-bottom">
                            {{ $comment->content . ' - ' . $comment->user->name . '_' . date('F j, Y', strtotime($comment->updated_at)) }}
                            @can('update', $comment)
                                <a href="#" data-toggle="modal" class="ml-3" data-target="#updateCommentModal" data-id="{{ $comment->id }}" data-content="{{ $comment->content }}">{{ trans('post._edit') }}</a>
                            @endcan
                            @can('delete', $comment)
                                <a href="#" class="delete-comment-button ml-1">{{ trans('post.delete') }}</a>
                            @endcan
                        </p>
                    </div>
                @endforeach
                <form action="{{ route('comments.store') }}" method="post">
                    <div class="form-group mt-2">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $questionId }}">
                        <input type="text" class="form-control border-0 bg-color-4" autocomplete="off" placeholder="{{ trans('post.comment_here') }}" name="content">
                        <button type="submit" class="mt-1 h-auto border-0 btn btn-success bg-color-3 small-text">
                            {{ trans('post.add_a_comment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between py-3">
        <h3>{{ trans('post.answers') }}</h3>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked />
                {{ trans('post._active') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off" />
                {{ trans('post.oldest') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off" />
                {{ trans('post.vote') }}
            </label>
        </div>
    </div>
    @foreach ($answers as $answer)
        <div class="row flex-nowrap mt-3 color-2 p-3">
            <div class="d-flex flex-column align-items-center post-left-column">
                @if (isset($answer->vote) && $answer->vote->vote === config('constants.up_vote'))
                    <i class="fa fa-caret-up fa-6x hover color-3 up-vote" aria-hidden="true" data-answer="{{ $answer->id }}"></i>
                @else
                    <i class="fa fa-caret-up fa-6x hover up-vote" aria-hidden="true" data-answer="{{ $answer->id }}"></i>
                @endif
                <h5>{{ $votesNumber }}</h5>
                @if (isset($answer->vote) && $answer->vote->vote === config('constants.down_vote'))
                    <i class="fa fa-caret-down fa-6x hover color-3 down-vote" aria-hidden="true" data-answer="{{ $answer->id }}"></i>
                @else
                    <i class="fa fa-caret-down fa-6x hover down-vote" aria-hidden="true" data-answer="{{ $answer->id }}"></i>
                @endif
                <i class="fa fa-history mt-3 hover" aria-hidden="true"></i>
            </div>
            <div class="post-right-column flex-grow-1 pt-2 pl-3">
                <p>
                    @if ($answer->contents)
                        <div class="viewer" content-id="{{ $answer->content->id }}"></div>
                    @endif
                </p>
                <div class="d-flex flex-wrap w-100">
                    <p class="d-inline-block alert alert-success px-1 py-0 mr-1">
                        <!-- Content -->
                    </p>
                </div>
                <div class="d-flex justify-content-between pr-3">
                    <div class="d-flex flex-nowrap">
                        <a href="#" class="pr-2 small-text share-btn">{{ trans('post.share') }}</a>
                        <a href="#" class="pr-2 small-text">{{ trans('post.edit') }}</a>
                    </div>
                    <div class="d-flex flex-wrap flex-grow-1 justify-content-end">
                        <div class="d-flex flex-wrap flex-grow-1 justify-content-end">
                            <div class="user-info text-break alert alert-success p-2 mr-2">
                                <p class="small-text m-0">
                                    {{ trans('post.answered')}} <span>{{ date('F j, Y', strtotime($answer->content->created_at)) }}</span>
                                </p>
                                <div class="d-flex">
                                    <img src="{{ asset('storage/default_avatar.png') }}" alt="{{ trans('post.avatar') }}" class="mr-2 small-avatar" />
                                    <p class="small-text m-0">
                                        {{ $answer->user->name }}
                                        <br />
                                        {{ $answer->user->location }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column border-top">
                    @foreach ($answer->comments as $comment)
                        <div>
                            @can('delete', $comment)
                                <form class="delete-comment-form" action="{{ route('comments.destroy', $comment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="question_id" value="{{ $questionId }}">
                                </form>
                            @endcan
                            <p class="m-0 pl-3 text-break border-bottom">
                                {{ $comment->content . ' - ' . $comment->user->name . '_' . date('F j, Y', strtotime($comment->updated_at)) }}
                                @can('update', $comment)
                                    <a href="#" data-toggle="modal" class="ml-3" data-target="#updateCommentModal" data-id="{{ $comment->id }}" data-content="{{ $comment->content }}">{{ trans('post._edit') }}</a>
                                @endcan
                                @can('delete', $comment)
                                    <a href="#" class="delete-comment-button ml-1">{{ trans('post.delete') }}</a>
                                @endcan
                            </p>
                        </div>
                    @endforeach
                    <form action="{{ route('comments.store') }}" method="post">
                        <div class="form-group mt-2">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $questionId }}">
                            <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                            <input type="text" class="form-control border-0 bg-color-4" autocomplete="off" placeholder="{{ trans('post.comment_here') }}" name="content">
                            <button type="submit" class="mt-1 h-auto border-0 btn btn-success bg-color-3 small-text">
                                {{ trans('post.add_a_comment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <div class="mt-5">
        <h2 class="ml-2">{{ trans('post.your_answer') }}</h2>
        <form action="{{ route('answers.store') }}" method="post" id="new-answer-form">
            @csrf
            <div id="editor"></div>
            <input type="hidden" name="question_id" value="{{ $questionId }}">
            <button class="btn text-nowrap mt-3 px-2 bg-color-2 color-4 review-btn" id="new-answer-submit">
                {{ trans('post.review') }}
            </button>
        </form>
    </div>
@endsection
