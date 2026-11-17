<a href="{{ route('recipes.show', $recipe) }}" 
    class="recipe-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition block">
    <div class="relative h-48 overflow-hidden">
        @if($recipe->image)
            <img src="{{ Storage::url($recipe->image) }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
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
                {{ $recipe->user->initial }}
            </div>
            <span class="text-sm text-gray-600">{{ $recipe->user->name }}</span>
        </div>
    </div>
</a>