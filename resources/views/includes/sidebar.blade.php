<div class="position-fixed h-100 side-bar bg-color-2 color-4" id="sidebar">
    <ul class="list-group list-group-flush sign-bar-content">
        <li class="list-group-item bg-color-2 active">
            <a href="{{ route('questions.index') }}" class="color-4 text-decoration-none hover">
                {{ trans('bars.posts') }}
            </a>
        </li>
        <li class="list-group-item bg-color-2">
            <a href="#" class="color-4 text-decoration-none hover">
                {{ trans('bars.tags')  }}
            </a>
        </li>
        <li class="list-group-item bg-color-2">
            <a href="#" class="color-4 text-decoration-none hover">
                {{ trans('bars.users')  }}
            </a>
        </li>
    </ul>
</div>
