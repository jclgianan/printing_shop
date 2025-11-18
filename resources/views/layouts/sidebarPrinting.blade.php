<aside class="receiving_sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/secretshop_logo.png') }}" alt="Logo" class="logo-image">
    </div>
    <nav class="receiving_nav-menu">
        <ul>
            <li><a href="{{route('main')}}" class="receiving_nav-link">Home</a></li>
            <li><a href="{{ route('printing') }}" class="receiving_nav-link active {{ request()->routeIs('printing') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="#" class="receiving_nav-link" {{ request()->routeIs('pending') ? 'active' : '' }} >Pending Items</a></li>
            <li><a href="#" class="receiving_nav-link {{ request()->routeIs('history') ? 'active' : '' }}">History</a></li>
            <li><a href="{{ route('add-new-user') }} " class="receiving_nav-link {{ request()->routeIs('add-new-user') ? 'active' : '' }}">Add Users</a></li>
            <li><a href="#" class="receiving_nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">Settings</a></li>
        </ul>
    </nav>
</aside>
