@extends('layouts.app')

@section('content')
    <div class="row justify-content-between flex-nowrap bord border-bottom">
        <h2 class="text-break color-1">{{ trans('list.all_questions') }}</h2>
        <form action="{{ route('questions.create') }}" method="get">
            <button type="submit" class="btn text-nowrap px-2 bg-color-2 color-4">
                {{ trans('list.ask_question') }}
            </button>
        </form>
    </div>
    <div class="row">
        @foreach ($tags as $tag)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 p-3 border">
                <a href="{{ route('tag_question', $tag->id) }}" class="d-inline-block alert alert-success px-1 py-0 my-0 mr-1">
                    {{ $tag->name }}
                </a>
                <p class="mt-2">{{ $tag->description }}</p>
                <small>{{ $tag->questions_count . trans('post.questions') }}</small>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-end mt-3">
        {{ $tags->links() }}
    </div>
@endsection
