@component('mail::message')
# Weekly Report

Posts Report {{ $now }}

@component('mail::table')
| Title | Number of Views | Number of Answers | Number of Comments |
|:------|:---------------:|:-----------------:|:------------------:|
@foreach ($questions as $question)
| {{ substr($question->title , 0, 20) . '...' }} | {{ $question->views_number }} | {{ $question->answers_count }} | {{ $question->comments_count }} |
@endforeach
| Total | {{ $questions->sum('views_number') }} | {{ $questions->sum('answers_count') }} | {{ $questions->sum('comments_count') }} |
@endcomponent

Thanks,<br>
## {{ config('app.name') }}
@endcomponent
