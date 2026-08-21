<!-- 1. SideNavBar Component -->
<nav class="bg-sidebar-bg text-secondary-fixed font-body-sm docked fixed-left w-sidebar-width h-full fixed top-0 left-0 z-50 flex flex-col justify-between hidden md:flex transition-all duration-200 ease-in-out">
<div class="w-full">
<!-- Header -->
<div class="h-16 flex items-center px-4 border-b border-surface-tint/20">
<div class="w-8 h-8 rounded bg-surface-tint flex items-center justify-center mr-3 overflow-hidden text-on-primary">
<span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
</div>
<div class="flex flex-col justify-center text-label-lg font-label-lg font-bold text-on-primary">
<span>INSPEKTORAT</span>
<span class="text-[10px] text-on-primary-container tracking-wider font-normal">KAB. PUNCAK JAYA</span>
</div>
</div>
<!-- Tab Links -->
<div class="py-4 flex flex-col gap-1 w-full text-label-md font-label-md">
<!-- Dashboard Link -->
<a class="flex items-center w-full h-[48px] {{ request()->routeIs('dashboard') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50' }} px-4 transition-all duration-150" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined mr-3 text-[20px]" style="{{ request()->routeIs('dashboard') ? "font-variation-settings: 'FILL' 1;" : '' }}">dashboard</span>
<span>Dashboard</span>
</a>
<!-- Manajemen Jabatan Link -->
<a class="flex items-center w-full h-[48px] {{ request()->routeIs('manajemen-jabatan') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50' }} px-4 transition-all duration-150" href="{{ route('manajemen-jabatan') }}">
<span class="material-symbols-outlined mr-3 text-[20px]" style="{{ request()->routeIs('manajemen-jabatan') ? "font-variation-settings: 'FILL' 1;" : '' }}">account_balance</span>
<span>Manajemen Jabatan</span>
</a>
<!-- Direktori ASN Link -->
<a class="flex items-center w-full h-[48px] {{ request()->routeIs('pegawai.index') || request()->routeIs('pegawai.show') || request()->routeIs('pegawai.create') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50' }} px-4 transition-all duration-150" href="{{ route('pegawai.index') }}">
<span class="material-symbols-outlined mr-3 text-[20px]" style="{{ request()->routeIs('pegawai.index') || request()->routeIs('pegawai.show') || request()->routeIs('pegawai.create') ? "font-variation-settings: 'FILL' 1;" : '' }}">groups</span>
<span>Direktori ASN</span>
</a>


<!-- Laporan Link -->
<a class="flex items-center w-full h-[48px] {{ request()->routeIs('laporan') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50' }} px-4 transition-all duration-150" href="{{ route('laporan') }}">
<span class="material-symbols-outlined mr-3 text-[20px]" style="{{ request()->routeIs('laporan') ? "font-variation-settings: 'FILL' 1;" : '' }}">analytics</span>
<span>Laporan</span>
</a>
<!-- Pengaturan Link -->
<a class="flex items-center w-full h-[48px] {{ request()->routeIs('pengaturan') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50' }} px-4 transition-all duration-150" href="{{ route('pengaturan') }}">
<span class="material-symbols-outlined mr-3 text-[20px]" style="{{ request()->routeIs('pengaturan') ? "font-variation-settings: 'FILL' 1;" : '' }}">settings</span>
<span>Pengaturan</span>
</a>

<div class="mt-auto mb-4 px-4 pt-4 border-t border-outline-variant/30">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center w-full h-[48px] text-error hover:bg-error/10 rounded px-4 transition-all duration-150 font-semibold">
            <span class="material-symbols-outlined mr-3 text-[20px]">logout</span>
            <span>Keluar Sistem</span>
        </button>
    </form>
</div>
</div>
</div>
<!-- Footer Profile -->
<div class="w-full pb-4">
<a class="flex items-center w-full h-[48px] text-on-primary-container hover:bg-primary-container/50 px-4 transition-colors text-label-md font-label-md" href="#">
<span class="material-symbols-outlined mr-3 text-[20px]">account_circle</span>
<span>Admin Profile</span>
</a>
</div>
</nav>
