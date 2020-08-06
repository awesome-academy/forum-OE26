@extends('layouts.app')

@section('content')
    <div class="row justify-content-between flex-nowrap">
        <h2 class="text-break color-1">
            <!--What is a NullPointerException, and how do I fix it?-->
        </h2>
        <button class="btn text-nowrap px-2 bg-color-2 color-4">
            {{ trans('post.ask_question') }}
        </button>
    </div>
    <div class="row border-bottom flex-nowrap">
        <p class="pr-1 text-secondary small-text">{{ trans('post.asked') }}</p>
        <p class="pr-2 small-text">
            <!--11 years, 9 months ago-->
        </p>
        <p class="pr-1 text-secondary small-text">{{ trans('post.active') }}</p>
        <p class="pr-2 small-text">
            <!--2 months ago-->
        </p>
        <p class="pr-1 text-secondary small-text">{{ trans('post.viewed') }}</p>
        <p class="small-text">
            <!--2.8m times-->
        </p>
    </div>
    <div class="row flex-nowrap mt-3 color-2">
        <div class="d-flex flex-column align-items-center post-left-column">
            <i class="fa fa-caret-up hover" aria-hidden="true"></i>
            <h5>
                <!-- Content -->
            </h5>
            <i class="fa fa-caret-down hover" aria-hidden="true"></i>
            <i class="far fa-bookmark hover" aria-hidden="true"></i>
            <i class="fa fa-history mt-2 hover" aria-hidden="true"></i>
        </div>
        <div class="post-right-column flex-grow-1 pt-2 pl-3">
            <p>
                <!-- Content -->
            </p>
            <div class="d-flex flex-wrap w-100 mb-4">
                <p class="d-inline-block alert alert-success px-1 py-0 mt-1 mb-0 mr-1">
                    <!-- Content -->
                </p>
            </div>
            <div class="d-flex justify-content-between pr-3">
                <div class="d-flex flex-nowrap">
                    <a href="#" class="pr-2 small-text">{{ trans('post.share') }}</a>
                    <a href="#" class="pr-2 small-text">{{ trans('post.edit') }}</a>
                    <a href="#" class="small-text">{{ trans('post.follow') }}</a>
                </div>
                <div class="d-flex flex-wrap flex-grow-1 justify-content-end">
                    <div class="user-info text-break alert alert-success p-2 mr-2">
                        <p class="small-text m-0">
                            {{ trans('post.edited') }} <span>
                                <!--Jan 3 '10 at 20:09--></span>
                        </p>
                        <div class="d-flex">
                            <img src="" alt="{{ trans('post.avatar') }}" class="mr-2 small-avatar" />
                            <p class="small-text m-0">
                                <!-- Name -->
                                <br />
                                <!-- Location -->
                            </p>
                        </div>
                    </div>
                    <div class="user-info text-break alert alert-success p-2 mr-2">
                        <p class="small-text m-0">
                            {{ trans('post._asked') }} <span>
                                <!--Jan 3 '10 at 20:09--></span>
                        </p>
                        <div class="d-flex">
                            <img src="" alt="{{ trans('post.avatar') }}" class="mr-2 small-avatar" />
                            <p class="small-text m-0">
                                <!-- Name -->
                                <br />
                                <!-- Location -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column border-top">
                <p class="m-0 pl-3 text-break border-bottom">
                    <!-- Content -->
                </p>
                <button class="mt-2 h-auto border-0 btn btn-success bg-color-3 small-text">
                    {{ trans('post.add_a_comment') }}
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between py-3">
        <h5>{{ trans('post.answers') }}</h5>
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
    <div class="row flex-nowrap mt-3 color-2">
        <div class="d-flex flex-column align-items-center post-left-column">
            <i class="fa fa-caret-up hover" aria-hidden="true"></i>
            <h5>
                <!-- Content -->
            </h5>
            <i class="fa fa-caret-down hover" aria-hidden="true"></i>
            <i class="far fa-bookmark hover" aria-hidden="true"></i>
            <i class="fa fa-history mt-2 hover" aria-hidden="true"></i>
        </div>
        <div class="post-right-column flex-grow-1 pt-2 pl-3">
            <p>
                <!-- Content -->
            </p>
            <div class="d-flex flex-wrap w-100">
                <p class="d-inline-block alert alert-success px-1 py-0 mr-1">
                    <!-- Content -->
                </p>
            </div>
            <div class="d-flex justify-content-between pr-3">
                <div class="d-flex flex-nowrap">
                    <a href="#" class="pr-2 small-text">{{ trans('post.share') }}</a>
                    <a href="#" class="pr-2 small-text">{{ trans('post.edit') }}</a>
                    <a href="#" class="small-text">{{ trans('post.follow') }}</a>
                </div>
                <div class="d-flex flex-wrap flex-grow-1 justify-content-end">
                    <div class="d-flex flex-wrap flex-grow-1 justify-content-end">
                        <div class="user-info text-break alert alert-success p-2 mr-2">
                            <p class="small-text m-0">
                                {{ trans('post.edited')}} <span>
                                    <!--Jan 3 '10 at 20:09--></span>
                            </p>
                            <div class="d-flex">
                                <img src="" alt="{{ trans('post.avatar') }}" class="mr-2 small-avatar" />
                                <p class="small-text m-0">
                                    <!-- Name -->
                                    <br />
                                    <!-- Location -->
                                </p>
                            </div>
                        </div>
                        <div class="user-info text-break alert alert-success p-2 mr-2">
                            <p class="small-text m-0">
                                {{ trans('post.answered')}} <span>
                                    <!--Jan 3 '10 at 20:09--></span>
                            </p>
                            <div class="d-flex">
                                <img src="" alt="{{ trans('post.avatar') }}" class="mr-2 small-avatar" />
                                <p class="small-text m-0">
                                    <!-- Name -->
                                    <br />
                                    <!-- Location -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column border-top">
                <p class="m-0 pl-3 text-break border-bottom">
                    <!-- Content -->
                </p>
                <button class="mt-2 h-auto border-0 btn btn-success bg-color-3 small-text">
                    {{ trans('post.add_a_comment') }}
                </button>
            </div>
        </div>
    </div>
@endsection
