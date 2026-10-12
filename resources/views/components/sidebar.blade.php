<!-- 1. SideNavBar Component -->
<nav class="bg-sidebar-bg text-secondary-fixed font-body-sm docked fixed-left w-sidebar-width h-full fixed top-0 left-0 z-50 flex flex-col justify-between hidden md:flex transition-all duration-200 ease-in-out shadow-lg">
<div class="w-full flex flex-col h-full">
<!-- Header -->
<div class="py-6 flex flex-col items-center px-4 border-b border-surface-tint/20 relative">
    <!-- Version Badge -->
    <span class="absolute top-3 right-3 text-[9px] font-bold bg-primary-container text-on-primary-container px-1.5 py-0.5 rounded shadow-sm">v1.2</span>
    
    <!-- 1. Logo di paling atas -->
    <div class="w-16 h-16 flex items-center justify-center mb-3 overflow-hidden bg-white/10 rounded-full p-1.5 ring-2 ring-white/20">
        <img src="{{ asset('logo-inspektorat.png') }}" alt="Logo" class="w-full h-full object-contain drop-shadow-md">
    </div>
    
    <!-- 2. Nama Aplikasi di bawah logo -->
    <div class="text-on-primary font-black text-xl mb-1 tracking-wide drop-shadow-sm">SIM-ASN</div>
    
    <!-- 3. Nama Instansi -->
    <div class="flex flex-col justify-center items-center text-center text-label-sm font-bold text-on-primary/90">
        <span>INSPEKTORAT</span>
        <span class="text-[10px] text-on-primary-container tracking-wider font-normal mt-0.5">KAB. PUNCAK JAYA</span>
    </div>
</div>

<!-- Tab Links -->
<div class="py-4 flex flex-col gap-1 w-full text-label-md font-label-md overflow-y-auto flex-1 custom-scrollbar">
    
    <!-- Group: UTAMA -->
    <div class="px-5 mt-2 mb-1">
        <span class="text-[10px] font-bold text-on-primary-container/70 tracking-widest uppercase">Utama</span>
    </div>
    
    <a class="flex items-center w-full h-[40px] {{ request()->routeIs('dashboard') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50 border-l-4 border-transparent' }} px-4 transition-all duration-150" href="{{ route('dashboard') }}">
        <span class="material-symbols-outlined mr-3 text-[18px]" style="{{ request()->routeIs('dashboard') ? "font-variation-settings: 'FILL' 1;" : '' }}">dashboard</span>
        <span>Dashboard</span>
    </a>

    <!-- Group: ADMINISTRASI -->
    <div class="px-5 mt-5 mb-1">
        <span class="text-[10px] font-bold text-on-primary-container/70 tracking-widest uppercase">Administrasi</span>
    </div>
    
    <a class="flex items-center w-full h-[40px] {{ request()->routeIs('manajemen-jabatan') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50 border-l-4 border-transparent' }} px-4 transition-all duration-150" href="{{ route('manajemen-jabatan') }}">
        <span class="material-symbols-outlined mr-3 text-[18px]" style="{{ request()->routeIs('manajemen-jabatan') ? "font-variation-settings: 'FILL' 1;" : '' }}">account_balance</span>
        <span>Manajemen Jabatan</span>
    </a>
    <a class="flex items-center w-full h-[40px] {{ request()->routeIs('pegawai.index') || request()->routeIs('pegawai.show') || request()->routeIs('pegawai.create') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50 border-l-4 border-transparent' }} px-4 transition-all duration-150" href="{{ route('pegawai.index') }}">
        <span class="material-symbols-outlined mr-3 text-[18px]" style="{{ request()->routeIs('pegawai.index') || request()->routeIs('pegawai.show') || request()->routeIs('pegawai.create') ? "font-variation-settings: 'FILL' 1;" : '' }}">groups</span>
        <span>Direktori ASN</span>
    </a>
    
    <!-- Group: ANALITIK & SISTEM -->
    <div class="px-5 mt-5 mb-1">
        <span class="text-[10px] font-bold text-on-primary-container/70 tracking-widest uppercase">Sistem & Laporan</span>
    </div>

    <a class="flex items-center w-full h-[40px] {{ request()->routeIs('laporan') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50 border-l-4 border-transparent' }} px-4 transition-all duration-150" href="{{ route('laporan') }}">
        <span class="material-symbols-outlined mr-3 text-[18px]" style="{{ request()->routeIs('laporan') ? "font-variation-settings: 'FILL' 1;" : '' }}">analytics</span>
        <span>Laporan Analitik</span>
    </a>
    <a class="flex items-center w-full h-[40px] {{ request()->routeIs('pengaturan') ? 'border-l-4 border-secondary-fixed bg-primary-container text-on-primary' : 'text-on-primary-container hover:bg-primary-container/50 border-l-4 border-transparent' }} px-4 transition-all duration-150" href="{{ route('pengaturan') }}">
        <span class="material-symbols-outlined mr-3 text-[18px]" style="{{ request()->routeIs('pengaturan') ? "font-variation-settings: 'FILL' 1;" : '' }}">settings</span>
        <span>Pengaturan</span>
    </a>
</div>

<!-- Footer Profile Card -->
<div class="w-full p-4 border-t border-surface-tint/20 mt-auto bg-surface-tint/5">
    <div class="flex items-center w-full bg-primary-container/20 rounded-lg p-2.5 border border-primary-container/20 hover:bg-primary-container/30 transition-colors cursor-default">
        <div class="w-8 h-8 rounded bg-primary-container text-on-primary flex items-center justify-center shrink-0 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
        </div>
        <div class="ml-3 overflow-hidden">
            <div class="text-label-sm font-bold text-on-primary truncate">Administrator</div>
            <div class="text-[9px] text-on-primary-container truncate opacity-80">{{ auth()->check() ? auth()->user()->email : 'admin@inspektorat.id' }}</div>
        </div>
    </div>
</div>
</div>
</nav>

<style>
/* Custom Scrollbar for sidebar */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255,255,255,0.2);
  border-radius: 4px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
  background: rgba(255,255,255,0.4);
}
</style>
