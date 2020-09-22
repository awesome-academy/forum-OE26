<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\Question\QuestionRepositoryInterface;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Vote\VoteRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    protected $commentRepository;
    protected $contentRepository;
    protected $questionRepository;
    protected $tagRepository;
    protected $userRepository;
    protected $voteRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository,
        ContentRepositoryInterface $contentRepository,
        QuestionRepositoryInterface $questionRepository,
        TagRepositoryInterface $tagRepository,
        UserRepositoryInterface $userRepository,
        VoteRepositoryInterface $voteRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->contentRepository = $contentRepository;
        $this->questionRepository = $questionRepository;
        $this->tagRepository = $tagRepository;
        $this->userRepository = $userRepository;
        $this->voteRepository = $voteRepository;

        $this->middleware('auth')->only(['create', 'store']);
    }

    public function getQuestionNotifications()
    {
        $notifications = Auth::user()->notifications;
        foreach ($notifications as $notification) {
            $notification->message = $this->userRepository
                ->find($notification->data['creation_user_id'])
                ->name . trans('messages.answer_created');
        }

        return $notifications;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = null;
        $questions = $this->questionRepository->with($questions, 'votes', 'user', 'tags');
        $questions = $this->questionRepository->withCount($questions, 'answers');

        $sortedBy = $request->query(config('constants.sorted_by'));

        if (isset($sortedBy)) {
            $request->session()
                ->put(config('constants.sorted_by'), $sortedBy);
        } else {
            $sortedBy = $request->session()
                ->get(config('constants.sorted_by'), config('constants.newest'));
        }

        switch ($sortedBy) {
            case config('constants.active'):
                $questions = $this->questionRepository->orderByDesc($questions, 'activities_count');
                break;
            case config('constants.unanswered'):
                $questions = $this->questionRepository->withCount($questions, 'answers');
                $questions = $this->questionRepository->orderByAsc($questions, 'answers_count', 'created_at');
                break;
            default:
                $questions = $this->questionRepository->orderByDesc($questions, 'created_at');
        }

        $questions = $this->questionRepository->paginate($questions, config('constants.questions_per_page'));
        $this->questionRepository->countVotesForPage($questions);

        $numberOfQuestions = $this->questionRepository->count(null);

        return view('post.list', compact(
            'questions',
            'numberOfQuestions',
            'sortedBy'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Question::class);

        $tags = $this->tagRepository->all();

        return view('post.create', compact([
            'tags',
        ]));
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

        $question = $this->questionRepository->create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'views_number' => config('constants.initial_view_number'),
            'activities_count' => config('constants.zero'),
        ]);

        $question->contents()
            ->create([
                'content' => $request->content,
                'version' => config('constants.initial_version'),
            ]);

        $this->contentRepository->createFromModel($question, [
            'content' => $request->content,
            'version' => config('constants.initial_version'),
        ]);

        $this->questionRepository->sync($question, 'tags', $request->tags);

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
        $this->questionRepository->update($question->id, ['views_number' => $question->views_number + config('constants.increasing_views_each_request')]);

        $questionId = $question->id;

        $title = $this->questionRepository->getTitle($question);

        $asked = $this->questionRepository->getAskedTimestamp($question);

        $viewsNumber = $question->views_number;

        $activesNumber = $question->activities_count;

        $votesNumber = $this->voteRepository->sumVote($question);

        $vote = $this->voteRepository->getVoteByUserId($question, Auth::id());

        $maxContentVersion = $this->contentRepository->maxVersion($question);
        $content = $this->contentRepository->findByVersion($maxContentVersion, $question);

        $comments = $this->commentRepository->getCommentsWithUser($question);

        $tags = $this->questionRepository->getTags($question);

        $user = $this->questionRepository->getUser($question);

        $answers = $this->questionRepository->getAnswers($question);

        $comments = $this->commentRepository->getCommentsWithUser($question);

        if (Auth::id() === $user->id) {
            foreach ($user->unreadNotifications as $notification) {
                if ($notification->data['question_id'] === $questionId) {
                    $notification->markAsRead();
                }
            }
        }

        return view('post.post', compact(
            'questionId',
            'question',
            'title',
            'asked',
            'viewsNumber',
            'activesNumber',
            'votesNumber',
            'vote',
            'tags',
            'user',
            'answers',
            'comments',
            'content',
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
        $this->authorize('update', $question);

        $questionId = $question->id;

        $title = $this->questionRepository->getTitle($question);

        $maxContentVersion = $this->contentRepository->maxVersion($question);
        $content = $this->contentRepository->findByVersion($maxContentVersion, $question);

        return view('post.edit', compact(
            'questionId',
            'title',
            'content',
        ));
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
        $this->authorize('update', $question);

        $this->questionRepository->update($question->id, [
            'title' => $request->title,
            'activities_count' => $question->activities_count + config('increasing_activities_count'),
            'active_at' => Carbon::now(),
        ]);

        $maxContentVersion = $this->contentRepository->maxVersion($question);
        $this->contentRepository->createFromModel($question, [
            'content' => $request->content,
            'version' => $maxContentVersion + 1,
        ]);

        return redirect()->route('questions.show', $question->id);
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
