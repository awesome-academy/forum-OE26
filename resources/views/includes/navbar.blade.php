<div class="navbar navbar-expand-lg pr-4 bg-color-1">
    <button class="mr-3 border-0 btn-dark color-3 side-bar-btn" id="sidebarBtn">
        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">
        <i class="fa fa-2x fa-carrot color-4"></i>
    </a>
    <div class="navbar-nav flex-grow-1">
        <form method="GET" action="{{ route('search') }}" class="form-inline my-2 my-lg-0 w-100" id="search-form">
            @if (isset($query))
                <input class="form-control w-100" type="search" placeholder="{{ trans('bars.search') }}" aria-label="Search"
                name="{{ config('constants.query') }}" list="search-datalist" autocomplete="off" id="search-input" value="{{ $query }}" />
            @else
                <input class="form-control w-100" type="search" placeholder="{{ trans('bars.search') }}" aria-label="Search"
                name="{{ config('constants.query') }}" list="search-datalist" autocomplete="off" id="search-input" />
            @endif
            <datalist id="search-datalist"></datalist>
            <button class="btn color-3 my-2 my-sm-0" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <button class="navbar-toggler ml-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars color-4" aria-hidden="true"></i>
    </button>
    <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle color-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ trans('bars.menu') }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item color-3" href="#">
                        {{ trans('bars.notifications') }}
                    </a>
                    <a class="dropdown-item color-3" href="#">
                        {{ trans('bars.profile') }}
                    </a>
                    @if (App::isLocale('en'))
                        <a class="dropdown-item color-3" href="{{ route('set_locale', ['locale' => 'vi']) }}">
                            {{ trans('bars.language') }}
                        </a>
                    @else
                        <a class="dropdown-item color-3" href="{{ route('set_locale', ['locale' => 'en']) }}">
                            {{ trans('bars.language') }}
                        </a>
                    @endif
                    @auth
                        <a class="dropdown-item color-3" id="logout-btn" href="#">
                            {{ trans('bars.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </div>
            </li>
            @guest
                <li class="nav-item">
                    <a class="nav-link color-3" href="{{ route('login') }}">
                        {{ trans('bars.login') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link color-3" href="{{ route('register') }}">
                        {{ trans('bars.register') }}
                    </a>
                </li>
            @endguest
        </ul>
    </div>
</div>
