<aside class="receiving_sidebar">
    <div class="login-logo">
        <img src="{{ asset('images/Capitol_Logo.png') }}" alt="Logo" class="logo-image">
    </div>
    <nav class="receiving_nav-menu">
        <ul>
            <li><a href="{{route('main')}}" class="receiving_nav-link">Home</a></li>
            <li><a href="{{ route('repair') }}" class="receiving_nav-link active">Dashboard</a></li>
            <li><a href="#" class="receiving_nav-link">Pending Items</a></li>
            <li><a href="#" class="receiving_nav-link">History</a></li>
            <li><a href="{{ route('add-new-user') }}" class="receiving_nav-link">Add Users</a></li>
            <li><a href="#" class="receiving_nav-link">Settings</a></li>
        </ul>
    </nav>
</aside>
