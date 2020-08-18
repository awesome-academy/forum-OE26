<?php

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Content;
use App\Models\Question;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 10)->create();

        $users->each(function ($user) {
            $questions = $user->questions()->createMany(
                factory(Question::class, rand(1, 10))->make()->toArray()
            );

            $questions->each(function ($question) {
                $answers = $question->answers()->createMany(
                    factory(Answer::class, rand(1, 10))->make()->toArray()
                );

                $randNbOfContents = rand(1, 5);
                for ($i = 0; $i < $randNbOfContents; $i++) {
                    $question->contents()->create(
                        factory(Content::class)->make(['version' => $i + 1])->toArray()
                    );
                }

                $question->comments()->createMany(
                    factory(Comment::class, rand(0, 10))->make()->toArray()
                );

                $question->votes()->createMany(
                    factory(Vote::class, rand(0, 50))->make()->toArray()
                );

                $answers->each(function ($answer) {
                    $randNbOfContents = rand(1, 5);
                    for ($i = 0; $i < $randNbOfContents; $i++) {
                        $answer->contents()->create(
                            factory(Content::class)->make(['version' => $i + 1])->toArray()
                        );
                    }

                    $answer->comments()->createMany(
                        factory(Comment::class, rand(0, 10))->make()->toArray()
                    );

                    $answer->votes()->createMany(
                        factory(Vote::class, rand(0, 50))->make()->toArray()
                    );
                });
            });
        });
    }
}
