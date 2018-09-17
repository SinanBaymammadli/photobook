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
            <a class="side-menu-item nav-link {{ str_contains(Route::currentRouteName(), 'user') ? 'active' : null }}"
                href="{{ route('user.index') }}">
                <i class="far fa-user"></i>
                <span>Users</span>
            </a>
            <a class="side-menu-item nav-link {{ str_contains(Route::currentRouteName(), 'order') && !str_contains(Route::currentRouteName(), 'album-order') ? 'active' : null }}"
                href="{{ route('order.index') }}">
                <i class="fas fa-truck"></i>
                <span>Orders</span>
            </a>
            <a class="side-menu-item nav-link {{ str_contains(Route::currentRouteName(), 'album-order') ? 'active' : null }}"
                href="{{ route('album-order.index') }}">
                <i class="fas fa-truck"></i>
                <span>Album Orders</span>
            </a>
            <a class="side-menu-item nav-link {{ str_contains(Route::currentRouteName(), 'category') ? 'active' : null }}"
                href="{{ route('category.index') }}">
                <i class="far fa-list-alt"></i>
                <span>Categories</span>
            </a>
            <a class="side-menu-item nav-link {{ str_contains(Route::currentRouteName(), 'product') ? 'active' : null }}"
                href="{{ route('product.index') }}">
                <i class="fas fa-book"></i>
                <span>Products</span>
            </a>
        </nav>
    </aside>
</div>
