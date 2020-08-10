@extends('layouts.app')

@section('content')
    <div class="row justify-content-between flex-nowrap">
        <h2 class="text-break color-1">{{ trans('list.all_questions') }}</h2>
        <button class="btn text-nowrap px-2 bg-color-2 color-4">
            {{ trans('list.ask_question') }}
        </button>
    </div>
    <div class="row justify-content-between pt-3 pb-1 border-bottom">
        <h5 class="align-self-end mb-0">
            <!-- 19,954,423 -->{{ trans('list.questions') }}
        </h5>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked />
                {{ trans('list.newest') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off" />
                {{ trans('list.active') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off" />
                {{ trans('list.unanswered') }}
            </label>
        </div>
    </div>
    <div class="row flex-nowrap color-2 border-bottom">
        <div class="d-flex flex-column align-items-center post-left-column-1 pt-3">
            <div class="d-flex flex-column align-items-center mb-1">
                <h5 class="mb-0 small-text">
                    <!-- 10 -->
                </h5>
                <p class="mb-0 small-text">
                    {{ trans('list.votes') }}
                </p>
            </div>
            <div class="d-flex flex-column align-items-center alert alert-success bg-color-3 p-2 mb-2">
                <h5 class="mb-0 mt-1 small-text">
                    <!-- 10 -->
                </h5>
                <p class="mb-0 small-text">
                    {{ trans('list.answers') }}
                </p>
            </div>
            <p class="mb-0 text-nowrap small-text">
                <!-- 21 -->{{ trans('list.views') }}
            </p>
        </div>
        <div class="post-right-column flex-grow-1 pl-3 d-flex flex-column">
            <div>
                <a class="color-3" href="">
                    <!-- Title -->
                </a>
                <p>
                    <!-- Content -->
                </p>
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
                            {{ trans('list.answered')}} <span>
                                <!--Jan 3 '10 at 20:09--></span>
                        </p>
                        <div class="d-flex">
                            <img src="" width="32" height="32" alt="avatar" class="mr-2" />
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
    </div>
@endsection
