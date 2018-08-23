<div>
    <aside class="side-menu">
        <a class="side-menu-logo" href="{{ route('home') }}">
            <i class="far fa-image"></i>
            <span>PhotoBook</span>
        </a>
        <nav class="nav flex-column">
            <a class="side-menu-item nav-link {{ Route::currentRouteName() == 'home' ? 'active' : null }}"
                href="{{ route('home') }}">
                <i class="far fa-sun"></i>
                <span>Dashboard</span>
            </a>
            <a class="side-menu-item nav-link {{ Route::currentRouteName() == 'user.index' ? 'active' : null }}"
                href="{{ route('user.index') }}">
                <i class="far fa-user"></i>
                <span>Users</span>
            </a>
        </nav>
    </aside>
</div>
