<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F8F9FA] font-sans text-gray-800 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between shrink-0">
            <div>
                <div class="h-16 flex items-center justify-between px-6 border-b border-gray-50">
                    <div class="flex items-center gap-3 font-bold text-xl tracking-tight text-gray-900">
                        <svg class="w-8 h-8 text-gray-900" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 0C7.16344 0 0 7.16344 0 16C0 24.8366 7.16344 32 16 32V16H32C32 7.16344 24.8366 0 16 0Z" fill="currentColor"/>
                        </svg>
                        <span>ERP</span>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10l-4-4m4 4l4-4m5-3V9m0 10v-4" />
                        </svg>
                    </button>
                </div>

                <nav class="mt-6 px-4 space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-gray-500 hover:bg-gray-50 rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-sm font-medium">Users</span>
                    </a>

                    <a href="/customers" class="flex items-center gap-3 px-4 py-2.5 {{ request()->is('customers') ? 'bg-[#EAEAEA] text-gray-900' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-sm font-medium">Customers</span>
                    </a>

                    <a href="/services" class="flex items-center gap-3 px-4 py-2.5 {{ request()->is('services') ? 'bg-[#EAEAEA] text-gray-900' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="text-sm font-medium">Services</span>
                    </a>

                    <a href="/subscriptions" class="flex items-center gap-3 px-4 py-2.5 {{ request()->is('subscriptions') ? 'bg-[#EAEAEA] text-gray-900' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="text-sm font-medium">Subscription</span>
                    </a>
                </nav>
            </div>
            
            <div class="p-4 border-t border-gray-50">
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-gray-500 hover:bg-gray-50 rounded-xl transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-sm font-medium">Sign Out</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 flex items-center px-8 bg-white border-b border-gray-100 shrink-0">
                <h1 class="text-sm font-medium text-gray-500 tracking-wide">@yield('title')</h1>
            </header>

            <div class="flex-1 overflow-auto p-8 bg-[#F8F9FA]">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>