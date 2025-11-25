<aside class="receiving_sidebar">
    <div class="shop_menu"><i class="fa-solid fa-list"></i></div>
    <div class="sidebar-logo-container">
        <img src="{{ asset('images/SecretShop_Logo_2.png') }}" alt="Logo" class="sidebar-logo">
    </div>
    {{-- <nav class="receiving_nav-menu">
        <ul>
            <li><a href="{{ route('main') }}" class="receiving_nav-link">Home</a></li>
            <li><a href="{{ route('printing') }}" class="receiving_nav-link {{ request()->routeIs('printing') ? 'active' : '' }}">Printing</a></li>
            <li><a href="{{ route('repair') }}" class="receiving_nav-link {{ request()->routeIs('repair') ? 'active' : '' }}">Repair</a></li>
            <li><a href="{{ route('add-new-user') }} " class="receiving_nav-link {{ request()->routeIs('add-new-user') ? 'active' : '' }}">Add Users</a></li>
            <li><a href="{{ route('activity.logs') }}" class="receiving_nav-link" {{ request()->routeIs('activity.logs') ? 'active' : '' }} >Activity Logs</a></li>
            <li><a href="#" class="receiving_nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">Settings</a></li>
        </ul>
    </nav> --}}
</aside>

{{-- to open the sidebar --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const leftSidebar = document.querySelector(".shop_sidebar");
    const menuBtn = document.querySelector(".receiving_sidebar .shop_menu");

    menuBtn.addEventListener("click", () => {
        leftSidebar.classList.toggle("open");
    });
});
</script>
