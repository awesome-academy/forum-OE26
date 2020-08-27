<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('dashboard');

        $users = User::withCount('questions')
            ->withCount('answers')
            ->withCount('comments')
            ->withCount('votes')
            ->paginate(config('constants.users_per_page'));

        $roles = Role::all();

        return view('admin.dashboard', compact(
            'users',
            'roles',
        ));
    }

    public function updateUserRole(Request $request)
    {
        Gate::authorize('dashboard');

        $user = User::findOrFail($request->userId);
        Gate::authorize('change_role', $user);

        $role = Role::where('name', $request->role)->firstOrFail();
        $user->update(['role_id' => $role->id]);

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

        Tag::create($request->all());

        return redirect()->route('create_tag');
    }
}
