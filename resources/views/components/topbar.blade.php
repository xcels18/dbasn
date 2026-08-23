<!-- 2. TopNavBar Component -->
<header class="bg-surface dark:bg-surface-dim text-primary dark:text-primary-fixed font-body-md docked full-width top-0 sticky border-b border-outline-variant flat no shadows flex justify-between items-center h-16 w-full pl-0 md:pl-sidebar-width pr-4 md:pr-margin-desktop z-40">
<div class="flex items-center h-full px-4 md:px-margin-desktop w-full justify-between">
<!-- Left side: Mobile Brand (hidden on desktop) / Search -->
<div class="flex items-center gap-4 flex-1">
<div class="md:hidden flex flex-col justify-center text-label-md font-bold text-primary">
<span>INSPEKTORAT KAB. PUNCAK JAYA</span>
</div>
<!-- Search Bar -->
<div class="hidden md:flex relative max-w-sm w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
<input class="w-full pl-10 pr-4 py-2 h-10 bg-surface-container-lowest border border-outline-variant rounded text-body-sm font-body-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Cari data ASN, dokumen..." type="text"/>
</div>
</div>
<!-- Right side actions -->
<div class="flex items-center gap-2 md:gap-4 shrink-0">
<!-- Icon Actions -->
<div class="flex items-center gap-1">
<button class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors Active: opacity-80">
<span class="material-symbols-outlined text-[20px]">notifications</span>
</button>
<button class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors Active: opacity-80">
<span class="material-symbols-outlined text-[20px]">help_outline</span>
</button>
</div>
<!-- Avatar with Dropdown -->
<div class="relative ml-2">
    <button id="profile-btn" class="w-8 h-8 rounded-full bg-surface-container-high border border-outline-variant overflow-hidden flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors focus:outline-none focus:ring-2 focus:ring-primary">
        <span class="material-symbols-outlined text-[20px]">person</span>
    </button>
    
    <!-- Dropdown Menu -->
    <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-surface rounded-lg shadow-md border border-border-subtle py-1 z-50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2.5 text-label-md text-error hover:bg-error/10 transition-colors font-semibold text-left">
                <span class="material-symbols-outlined mr-3 text-[18px]">logout</span>
                <span>Keluar Sistem</span>
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileBtn = document.getElementById('profile-btn');
        const profileMenu = document.getElementById('profile-menu');
        
        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });
            
            document.addEventListener('click', function(e) {
                if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
</div>
</div>
</header>
