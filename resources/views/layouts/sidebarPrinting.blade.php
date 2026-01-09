<aside class="receiving_topbar">
    <div class="header-left">
        <div class="shop_menu" data-tooltip="Menu"><i class="fa-solid fa-list"></i></div>

        <div class="logo-container">
            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" class="topbar-logo">
            <div class="clock-container">
                <div id="clock" class="clock" data-tooltip="Philippine Standard Time" data-pos="top">00:00:00
                </div>
                <div id="date" class="date">January 1, 2000</div>
            </div>
        </div>
    </div>

    <div class="header-right">
        <div class="user-info">



            <div class="user-details">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-email">{{ Auth::user()->email }}</span>
            </div>
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
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
