@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($contents as $content)
            <div class="boder m-2">
                <h2>{{ 'Version ' . $content->version }}</h2>
                <p>{{ $content->content }}</p>
            </div>
        @endforeach
    </div>
@endsection
