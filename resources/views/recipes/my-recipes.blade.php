@extends('layouts.app')

@section('title', 'Công thức của tôi - CookShare')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📝 Công thức của tôi</h1>
        <a href="{{ route('recipes.create') }}" class="flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm công thức mới
        </a>
    </div>

    @if($recipes->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($recipes as $recipe)
                <div class="recipe-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition relative">
                    <!-- Delete Button -->
                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="absolute top-3 right-3 z-10"
                        onsubmit="return confirm('Bạn có chắc muốn xóa công thức này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>

                    <!-- Edit Button -->
                    <a href="{{ route('recipes.edit', $recipe) }}" class="absolute top-3 right-14 z-10 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center hover:bg-blue-600 transition shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>

                    <a href="{{ route('recipes.show', $recipe) }}" class="block">
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
                            <div class="mt-3 pt-3 border-t border-gray-100 text-sm text-gray-500">
                                📅 Đăng {{ $recipe->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $recipes->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
            <span class="text-6xl mb-4 block">🍳</span>
            <p class="text-gray-500 text-lg mb-4">Bạn chưa đăng công thức nào.</p>
            <a href="{{ route('recipes.create') }}" class="inline-block px-6 py-3 bg-orange-500 text-white rounded-full font-semibold hover:bg-orange-600 transition">
                Đăng công thức đầu tiên
            </a>
        </div>
    @endif
</div>
@endsection