<aside class="receiving_topbar">
    <div class="header-left">
        <div class="shop_menu"><i class="fa-solid fa-list"></i></div>
            <img src="{{ asset('images/Secret_Shop_Logo.png') }}" alt="Logo" class="topbar-logo">
        
    </div>
    <div class="header-right">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-email">{{ Auth::user()->email }}</span>
            </div>
            
        </div>
    </div>
</aside>

{{-- to open the sidebar --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const leftSidebar = document.querySelector(".shop_sidebar");
    const menuBtn = document.querySelector(".receiving_topbar .shop_menu");

    menuBtn.addEventListener("click", () => {
        leftSidebar.classList.toggle("open");
    });
});
</script>
