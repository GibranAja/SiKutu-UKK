<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Siswa - Sikutu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-montserrat text-gray-800 bg-gray-50 antialiased flex h-screen overflow-hidden transition-colors duration-300 ease-in-out" x-data="{ sidebarOpen: false }">
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col">
        <div class="flex items-center justify-center h-16 border-b border-gray-200 px-4">
            <h1 class="font-oswald text-2xl font-bold text-blue-600">SIKUTU SISWA</h1>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('siswa.dashboard') }}" class="sidebar-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('siswa.katalog.index') }}" class="sidebar-link {{ request()->routeIs('siswa.katalog.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Katalog Buku
            </a>
            <a href="{{ route('siswa.peminjaman.index') }}" class="sidebar-link {{ request()->routeIs('siswa.peminjaman.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Histori Peminjaman
            </a>
            <a href="{{ route('siswa.denda.index') }}" class="sidebar-link {{ request()->routeIs('siswa.denda.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Denda Saya
            </a>
        </nav>
        <div class="p-4 border-t border-gray-200">
            <a href="{{ route('siswa.profile') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors duration-300 ease-in-out">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                    {{ substr(Auth::guard('anggota')->user()->nama_lengkap ?? 'S', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ Auth::guard('anggota')->user()->nama_lengkap ?? 'Siswa' }}</p>
                </div>
            </a>
            <button @click="$dispatch('open-logout-modal')" type="button" class="w-full text-left flex items-center text-red-600 hover:text-red-700 transition-colors duration-300 ease-in-out text-sm font-medium mt-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </div>
    </aside>

    <!-- Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 md:hidden transition-opacity duration-300 ease-in-out"></div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 md:px-6">
            <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none transition-colors duration-300 ease-in-out">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="ml-auto flex items-center">
                <h2 class="font-oswald text-xl text-gray-700 hidden sm:block">@yield('header')</h2>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
            @yield('content')
        </div>
    </main>

    <!-- Logout Confirmation Modal -->
    <div x-data="{ showLogoutModal: false }" 
         @open-logout-modal.window="showLogoutModal = true"
         x-show="showLogoutModal"
         x-cloak
         class="fixed inset-0 z-[99] flex items-center justify-center">
        
        {{-- Backdrop --}}
        <div x-show="showLogoutModal"
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showLogoutModal = false"
             class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

        {{-- Modal Panel --}}
        <div x-show="showLogoutModal"
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in-out duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6 text-center">
            
            {{-- Icon --}}
            <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="font-oswald text-xl font-bold text-gray-800 mb-2">Konfirmasi Logout</h3>
            <p class="text-gray-500 text-sm mb-6">Apakah Anda yakin ingin keluar dari sistem? Sesi Anda akan berakhir.</p>

            {{-- Actions --}}
            <div class="flex items-center justify-center gap-3">
                <button @click="showLogoutModal = false" type="button"
                        class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-100 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-red-600 text-white text-sm font-medium hover:bg-red-700 shadow-lg shadow-red-200 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-400">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Global Toaster -->
    <div class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2 pointer-events-none">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                 class="bg-emerald-500 text-white px-6 py-3 rounded shadow-lg flex items-center pointer-events-auto">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-montserrat text-sm font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-4 focus:outline-none hover:text-emerald-200">&times;</button>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                 class="bg-red-500 text-white px-6 py-3 rounded shadow-lg flex flex-col pointer-events-auto max-w-sm">
                <div class="flex justify-between items-start">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-montserrat text-sm font-medium">{{ session('error') ?? $errors->first() }}</span>
                    </div>
                    <button @click="show = false" class="ml-4 focus:outline-none hover:text-red-200">&times;</button>
                </div>
            </div>
        @endif
    </div>

</body>
</html>