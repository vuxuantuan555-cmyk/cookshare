<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CookShare - Chia Sẻ Công Thức Nấu Ăn')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-script { font-family: 'Dancing Script', cursive; }
        .recipe-card:hover { transform: translateY(-5px); }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .modal { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .slide-up { animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>
    @stack('styles')
</head>
<body class="bg-orange-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-4xl">🍳</span>
                    <span class="font-script text-3xl text-orange-600">CookShare</span>
                </a>
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-xl mx-8 hidden md:block">
                    <form action="{{ route('recipes.search') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm công thức..." 
                                class="w-full px-4 py-2 pl-10 rounded-full border border-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-400">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </form>
                </div>

                @guest
                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-orange-600 hover:text-orange-700 font-medium">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 font-medium">
                            Đăng ký
                        </a>
                    </div>
                @else
                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('recipes.create') }}" class="flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Đăng công thức
                        </a>
                        <div class="relative">
                            <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-orange-100">
                                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('recipes.my') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-50">📝 Công thức của tôi</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">🚪 Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative slide-up" role="alert">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative slide-up" role="alert">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
            <p>© {{ date('Y') }} CookShare. Made with ❤️ for food lovers.</p>
        </div>
    </footer>

    <script>
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !e.target.closest('.relative')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html> 