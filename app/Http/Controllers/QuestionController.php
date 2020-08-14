<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Question::class);

        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $this->authorize('create', Question::class);

        $question = Question::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'views_number' => config('constants.initial_view_number'),
        ]);

        $question->contents()
            ->create([
                'content' => $request->content,
                'version' => config('constants.initial_version')
            ]);

        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->update(['views_number' => $question->views_number + config('constants.increasing_views_each_request')]);

        $title = $question->title;

        $subtract = Carbon::now()->diff(Carbon::parse($question->created_at));
        $asked = $subtract->y > config('constants.zero')
            ? [
                'y' => $subtract->y,
                'm' => $subtract->m
            ]
            : ($subtract->m > config('constants.zero')
                ? [
                    'm' => $subtract->m,
                    'd' => $subtract->d
                ]
                : ($subtract->d > config('constants.zero')
                    ? [
                        'd' => $subtract->d,
                        'h' => $subtract->h
                    ]
                    : ($subtract->h > config('constants.zero')
                        ? [
                            'h' => $subtract->h,
                            'i' => $subtract->i
                        ]
                        : [
                            'i' => $subtract->i,
                            's' => $subtract->s
                        ])));

        $viewsNumber = $question->views_number;
        $votesNumber = $question->votes()->sum('vote');

        $maxContentVersion = $question->contents()->max('version');

        $contentCollection = $question
            ->contents()
            ->where('version', $maxContentVersion)
            ->first();
        $contentId = isset($contentCollection) ? $contentCollection->id : config('constants.zero');

        return view('post.post', compact(
            'title',
            'asked',
            'viewsNumber',
            'votesNumber',
            'contentId'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
