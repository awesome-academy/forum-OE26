@extends('admin.layouts.app')

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">{{ trans('admin.dashboard') }}</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    {{ trans('admin.users') }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.name')  }}</th>
                                    <th>{{ trans('admin.questions')  }}</th>
                                    <th>{{ trans('admin.answers')  }}</th>
                                    <th>{{ trans('admin.comments')  }}</th>
                                    <th>{{ trans('admin.votes')  }}</th>
                                    <th>{{ trans('admin.role')  }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->questions_count }}</td>
                                        <td>{{ $user->answers_count }}</td>
                                        <td>{{ $user->comments_count }}</td>
                                        <td>{{ $user->votes_count }}</td>
                                        <td>
                                            <form action="{{ route('update_role') }}" method="POST" class="form-inline d-flex justify-content-between">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="userId" value="{{ $user->id }}">
                                                <div class="form-group mr-2">
                                                    <select name="role" class="form-control">
                                                        @foreach ($roles as $role)
                                                            @if ($user->role_id === $role->id)
                                                                <option value="{{ $role->name }}" selected>{{ $role->description }}</option>
                                                            @else
                                                                <option value="{{ $role->name }}">{{ $role->description }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">{{ trans('admin.update_role') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
