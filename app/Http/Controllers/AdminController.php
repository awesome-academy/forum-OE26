<?php

namespace App\Http\Controllers;

use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    protected $roleRepository;
    protected $tagRepository;
    protected $userRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        TagRepositoryInterface $tagRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->tagRepository = $tagRepository;
        $this->userRepository = $userRepository;

        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('dashboard');

        $users = $this->userRepository->getUserDashboard(config('constants.users_per_page'));

        $roles = $this->roleRepository->all();

        return view('admin.dashboard', compact(
            'users',
            'roles',
        ));
    }

    public function updateUserRole(Request $request)
    {
        Gate::authorize('dashboard');

        $user = $this->userRepository->find($request->userId);
        Gate::authorize('change_role', $user);

        $role = $this->roleRepository->findByName($request->role);
        $this->userRepository->selfUpdate($user, ['role_id' => $role->id]);

        return redirect()->route('admin');
    }

    public function createTag()
    {
        Gate::authorize('dashboard');

        return view('admin.tag');
    }

    public function storeTag(Request $request)
    {
        Gate::authorize('dashboard');

        $this->tagRepository->create($request->all());

        return redirect()->route('create_tag');
    }

    public function userChart()
    {
        Gate::authorize('dashboard');

        return view('admin.chart');
    }
}
