@extends('layouts.app')

@section('title', isset($currentCategory) ? $currentCategory . ' - CookShare' : 'CookShare - Chia Sẻ Công Thức Nấu Ăn')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-400 to-red-500 rounded-3xl p-8 md:p-12 mb-8 text-white">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Khám Phá & Chia Sẻ Công Thức Nấu Ăn</h1>
            <p class="text-lg md:text-xl opacity-90 mb-6">Cộng đồng yêu bếp lớn nhất Việt Nam. Hàng ngàn công thức ngon đang chờ bạn!</p>
            <a href="#recipes" class="inline-block px-6 py-3 bg-white text-orange-600 rounded-full font-semibold hover:bg-orange-50 transition">
                Khám phá ngay
            </a>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Danh mục</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('home') }}" 
                class="px-4 py-2 rounded-full font-medium transition {{ !isset($currentCategory) && !isset($keyword) ? 'bg-orange-500 text-white hover:bg-orange-600' : 'bg-white text-gray-700 hover:bg-orange-100' }}">
                Tất cả
            </a>
            @foreach($categories as $category)
                <a href="{{ route('recipes.category', $category) }}" 
                    class="px-4 py-2 rounded-full font-medium transition {{ isset($currentCategory) && $currentCategory === $category ? 'bg-orange-500 text-white hover:bg-orange-600' : 'bg-white text-gray-700 hover:bg-orange-100' }}">
                    @switch($category)
                        @case('Món chính') 🍖 @break
                        @case('Món phụ') 🥗 @break
                        @case('Tráng miệng') 🍰 @break
                        @case('Đồ uống') 🧋 @break
                        @case('Món chay') 🥬 @break
                    @endswitch
                    {{ $category }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Recipe Grid -->
    <div id="recipes">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            @if(isset($keyword) && $keyword)
                Kết quả tìm kiếm: "{{ $keyword }}"
            @elseif(isset($currentCategory))
                Công thức: {{ $currentCategory }}
            @else
                Công thức mới nhất
            @endif
        </h2>

        @if($recipes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($recipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer block">
                        <div class="relative h-48 overflow-hidden">
                            @if($recipe->image)
                                @if(Str::startsWith($recipe->image, 'http'))
                                    <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                                @endif
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-200 to-orange-300 flex items-center justify-center">
                                    <span class="text-6xl">🍽️</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 px-3 py-1 bg-orange-500 text-white text-sm rounded-full">
                                {{ $recipe->category }}
                            </span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-1">{{ $recipe->name }}</h3>
                            <p class="text-gray-500 text-sm mb-3 line-clamp-2">
                                {{ $recipe->description ?: 'Công thức ngon tuyệt vời!' }}
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center gap-1">
                                    <span class="text-yellow-500">★</span>
                                    <span>
                                        @if($recipe->average_rating > 0)
                                            {{ number_format($recipe->average_rating, 1) }}
                                        @else
                                            Chưa có
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span>💬</span>
                                    <span>{{ $recipe->comments->count() }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span>⏱️</span>
                                    <span>{{ $recipe->cook_time }}</span>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-2">
                                <div class="w-6 h-6 bg-orange-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($recipe->user->name, 0, 1)) }}
                                </div>
                                <span class="text-sm text-gray-600">{{ $recipe->user->name }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $recipes->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <span class="text-6xl mb-4 block">🍳</span>
                <p class="text-gray-500 text-lg">Chưa có công thức nào. Hãy là người đầu tiên chia sẻ!</p>
                @auth
                    <a href="{{ route('recipes.create') }}" class="inline-block mt-4 px-6 py-3 bg-orange-500 text-white rounded-full font-semibold hover:bg-orange-600 transition">
                        Đăng công thức ngay
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection