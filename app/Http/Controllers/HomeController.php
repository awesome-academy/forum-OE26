<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        return view('home', compact([
            'user',
        ]));
    }

    public function editProfile(UserRequest $request)
    {
        $this->userRepository->update(Auth::id(), $request->all());

        return redirect()->route('home');
    }
}
