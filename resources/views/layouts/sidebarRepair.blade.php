<aside class="shop_sidebar">
    
    <nav class="shop_nav-menu">
        <ul>
            <li><a href="{{route('main')}}" class="shop_nav-link {{ request()->routeIs('main') ? 'active' : '' }}">
                <span class="menu_icon"><i class="fa-solid fa-house"></i></span>
                <span class="menu_text">Dashboard</span>
            </a></li>
            <li><a href="{{ route('printing') }}" class="shop_nav-link {{ request()->routeIs('printing') ? 'active' : '' }}">
                <span class="menu_icon"><i class="fa-solid fa-print"></i></span>
                <span class="menu_text">Printing</span>
            </a></li>
            <li><a href="{{ route('repair') }}" class="shop_nav-link {{ request()->routeIs('repair') ? 'active' : '' }}">
                <span class="menu_icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                <span class="menu_text">Repair</span>
            </a></li>
            <li><a href="{{ route('add-new-user') }} " class="shop_nav-link {{ request()->routeIs('add-new-user') ? 'active' : '' }}">
                <span class="menu_icon"><i class="fa-solid fa-users"></i></span>
                <span class="menu_text">Users</span>
            </a></li>
            <li><a href="{{ route('activity.logs') }}" class="shop_nav-link {{ request()->routeIs('activity.logs') ? 'active' : '' }}">
                <span class="menu_icon"><i class="fa-regular fa-clock"></i></span>
                <span class="menu_text">Activity Logs</span>
            </a></li>
            <li><a href="#" class="shop_nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                <span class="menu_icon"><i class="fa-solid fa-gear"></i></span>
                <span class="menu_text">Settings</span>
            </a></li> 
        </ul>
    </nav>
</aside>
