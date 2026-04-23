<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sikutu - Sistem Informasi Perpustakaan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-montserrat text-gray-800 bg-gray-50 antialiased min-h-screen flex flex-col transition-colors duration-300 ease-in-out">
    <main class="flex-grow flex items-center justify-center p-4">
        @yield('content')
    </main>

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

        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                 class="bg-red-500 text-white px-6 py-3 rounded shadow-lg flex flex-col pointer-events-auto max-w-sm">
                <div class="flex justify-between items-start">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-montserrat text-sm font-medium">{{ $errors->first() }}</span>
                    </div>
                    <button @click="show = false" class="ml-4 focus:outline-none hover:text-red-200">&times;</button>
                </div>
            </div>
        @endif
    </div>
</body>
</html>