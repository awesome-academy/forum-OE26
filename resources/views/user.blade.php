@extends('layouts.app')

@section('content')
    <div class="row justify-content-between pt-3 pb-1 border-bottom">
        <h2 class="mb-0">
            {{ trans('user.users') }}
        </h2>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked />
                {{ trans('user.day') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off" />
                {{ trans('user.week') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off" />
                {{ trans('user.month') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off" />
                {{ trans('user.year') }}
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off" />
                {{ trans('user.all') }}
            </label>
        </div>
    </div>
    <div class="row mx-2 user-container">
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 text-break p-2 border">
            <div class="d-flex">
                <img src="" alt="{{ trans('user.avatar') }}" class="mr-2 medium-avatar" />
                <p class="small-text m-0">
                    <!-- Name -->
                    <br />
                    <!-- Location -->
                </p>
            </div>
        </div>
    </div>
@endsection
