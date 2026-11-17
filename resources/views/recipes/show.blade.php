@extends('layouts.app')

@section('title', $recipe->name . ' - CookShare')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
        <!-- Image -->
        <div class="relative h-64 md:h-80">
            @if($recipe->image)
                @if(Str::startsWith($recipe->image, 'http'))
                    <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                @endif
            @else
                <div class="w-full h-full bg-gradient-to-br from-orange-200 to-orange-300 flex items-center justify-center">
                    <span class="text-8xl">🍽️</span>
                </div>
            @endif
            <a href="{{ route('home') }}" class="absolute top-4 left-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <span class="absolute bottom-4 left-4 px-4 py-2 bg-orange-500 text-white rounded-full font-medium">
                {{ $recipe->category }}
            </span>
        </div>

        <div class="p-6 md:p-8">
            <!-- Title & Author -->
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $recipe->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $recipe->description }}</p>

            <div class="flex flex-wrap items-center gap-4 mb-6">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($recipe->user->name, 0, 1)) }}
                    </div>
                    <span class="font-medium text-gray-700">{{ $recipe->user->name }}</span>
                </div>
                <div class="flex items-center gap-1 text-yellow-500">
                    <span class="text-xl">★</span>
                    <span class="text-gray-700 font-medium">
                        {{ $recipe->average_rating > 0 ? number_format($recipe->average_rating, 1) : 'Chưa đánh giá' }}
                    </span>
                    <span class="text-gray-500">({{ $recipe->ratings_count }} đánh giá)</span>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-orange-50 p-4 rounded-xl text-center">
                    <span class="text-2xl mb-1 block">⏱️</span>
                    <span class="text-sm text-gray-500">Thời gian</span>
                    <p class="font-semibold text-gray-800">{{ $recipe->cook_time }}</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-xl text-center">
                    <span class="text-2xl mb-1 block">👥</span>
                    <span class="text-sm text-gray-500">Khẩu phần</span>
                    <p class="font-semibold text-gray-800">{{ $recipe->servings }}</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-xl text-center">
                    <span class="text-2xl mb-1 block">🥗</span>
                    <span class="text-sm text-gray-500">Nguyên liệu</span>
                    <p class="font-semibold text-gray-800">{{ count($recipe->ingredients) }} món</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-xl text-center">
                    <span class="text-2xl mb-1 block">📝</span>
                    <span class="text-sm text-gray-500">Các bước</span>
                    <p class="font-semibold text-gray-800">{{ count($recipe->steps) }} bước</p>
                </div>
            </div>

            <!-- Ingredients & Steps -->
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span>🥗</span> Nguyên liệu
                    </h2>
                    <ul class="space-y-2">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                <span>{{ $ingredient }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span>👨‍🍳</span> Cách làm
                    </h2>
                    <ol class="space-y-4">
                        @foreach($recipe->steps as $index => $step)
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <p class="pt-1">{{ $step }}</p>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <!-- Rating Section -->
            <div class="bg-orange-50 p-6 rounded-xl mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Đánh giá món ăn</h2>
                @auth
                    <form action="{{ route('ratings.store', $recipe) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <span class="text-gray-600">Đánh giá của bạn:</span>
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="submit" name="rating" value="{{ $i }}" 
                                    class="text-3xl hover:scale-110 transition {{ $i <= ($recipe->user_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400">
                                    ★
                                </button>
                            @endfor
                        </div>
                    </form>
                @else
                    <p class="text-gray-600">
                        <a href="{{ route('login') }}" class="text-orange-600 font-medium hover:underline">Đăng nhập</a> để đánh giá món ăn
                    </p>
                @endauth
            </div>

            <!-- Comments Section -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Bình luận ({{ $recipe->comments->count() }})</h2>

                @auth
                    <form action="{{ route('comments.store', $recipe) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex gap-3">
                            <div class="w-10 h-10 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <textarea name="content" rows="2" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none"
                                    placeholder="Viết bình luận của bạn...">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="mt-2 px-6 py-2 bg-orange-500 text-white rounded-lg font-medium hover:bg-orange-600 transition">
                                    Gửi bình luận
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <p class="mb-6 text-gray-600 bg-gray-50 p-4 rounded-lg">
                        <a href="{{ route('login') }}" class="text-orange-600 font-medium hover:underline">Đăng nhập</a> để bình luận
                    </p>
                @endauth

                <div class="space-y-4">
                    @forelse($recipe->comments as $comment)
                        <div class="flex gap-3 p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if(auth()->id() === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                                            onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 text-sm hover:underline">Xóa</button>
                                        </form>
                                    @endif
                                </div>
                                <p class="text-gray-700">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection