<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function getHistory($type, $id)
    {
        $contents = [];
        if ($type === config('constants.question')) {
            $contents = Question::findOrFail($id)
                ->contents()
                ->orderByDesc('version')
                ->get();
        }

        if ($type === config('constants.answer')) {
            $contents = Answer::findOrFail($id)
                ->contents()
                ->orderByDesc('version')
                ->get();
        }

        return view('history', compact([
            'contents',
        ]));
    }
}
