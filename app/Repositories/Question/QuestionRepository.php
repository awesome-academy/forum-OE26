<?php

namespace App\Repositories\Question;

use App\Models\Question;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    public function getModel(): string
    {
        return Question::class;
    }

    public function countVotesForPage(LengthAwarePaginator $page): void
    {
        $page->map(function ($item) {
            $item->sum_votes = $item->votes->sum('vote');
        });
    }

    public function getTitle(Model $question): string
    {
        return $question->title;
    }

    public function getAskedTimestamp(Model $question): array
    {
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

        return $asked;
    }

    public function getTags(Model $question): Collection
    {
        return $question->tags;
    }

    public function getUser(Model $question): Model
    {
        return $question->user;
    }

    public function getAnswers(Model $question): Collection
    {
        $answers = $question->answers()
            ->with([
                'user',
                'votes',
                'comments.user',
            ])
            ->get();

        $answers->map(function ($answer) {
            $maxContentVersion = $answer->contents()->max('version');
            $answer->content = $answer->contents()
                ->where('version', $maxContentVersion)
                ->first();

            $answer->sum_votes = $answer->votes->sum('vote');

            $answer->vote =  $answer->votes()
                ->where('user_id', Auth::id())
                ->first();
        });

        return $answers;
    }

    public function search(string $query): SupportCollection
    {
        return Question::where('title', 'LIKE', '%' . $query . '%')
            ->limit(config('constants.search_result_limit'))
            ->pluck('title');
    }

    public function addSearchCondition(Builder $query, string $searchString): Builder
    {
        return $query->where('title', 'LIKE', '%' . $searchString . '%');
    }

    public function getLastWeekQuestions(): Builder
    {
        return Question::where('created_at', '>=', Carbon::now()->subWeek());
    }

    public function countComments(Builder $query): Collection
    {
        $questions = $query->with(['answers' => function ($query) {
            $query->withCount('comments');
        }])
            ->get();

        foreach ($questions as $question) {
            if ($question->comments_count) {
                $question->comments_count += $question->answers->sum('comments_count');
            } else {
                $question->comments_count = $question->answers->sum('comments_count');
            }
        }

        return $questions;
    }
}
