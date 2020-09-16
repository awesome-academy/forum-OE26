<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">{{ trans('admin.dashboard') }}</div>
                <a class="nav-link" href="{{ route('admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    {{ trans('admin.users') }}
                </a>
                <a class="nav-link" href="{{ route('create_tag') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    {{ trans('admin.tags') }}
                </a>
                <a class="nav-link" href="{{ route('chart') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    {{ trans('admin.chart') }}
                </a>
            </div>
        </div>
    </nav>
</div>
