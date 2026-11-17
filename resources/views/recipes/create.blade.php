@extends('layouts.app')

@section('title', 'Đăng công thức mới - CookShare')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-lg p-8 slide-up">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Đăng công thức mới</h1>
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        </div>

        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Tên món ăn *</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="VD: Phở bò Hà Nội">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Danh mục *</label>
                <select name="category" required 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Thời gian nấu *</label>
                    <input type="text" name="cook_time" value="{{ old('cook_time') }}" required 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="VD: 30 phút">
                    @error('cook_time')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Khẩu phần *</label>
                    <input type="text" name="servings" value="{{ old('servings') }}" required 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="VD: 4 người">
                    @error('servings')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Mô tả ngắn</label>
                <textarea name="description" rows="2"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Mô tả ngắn về món ăn...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Hình ảnh món ăn</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-400 transition cursor-pointer relative">
                    <input type="file" name="image" accept="image/*" 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="previewImage(this)">
                    <div id="imagePreview" class="hidden mb-4">
                        <img id="previewImg" class="max-h-48 mx-auto rounded-lg">
                    </div>
                    <div id="uploadPlaceholder">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-500">Nhấp để tải ảnh lên (tối đa 5MB)</p>
                    </div>
                </div>
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nguyên liệu * (mỗi dòng một nguyên liệu)</label>
                <textarea name="ingredients" rows="5" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="500g thịt bò&#10;1 củ hành tây&#10;2 thìa dầu ăn&#10;...">{{ old('ingredients') }}</textarea>
                @error('ingredients')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Các bước thực hiện * (mỗi dòng một bước)</label>
                <textarea name="steps" rows="6" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Rửa sạch thịt bò, thái lát mỏng&#10;Ướp thịt với gia vị 15 phút&#10;Phi hành cho thơm&#10;...">{{ old('steps') }}</textarea>
                @error('steps')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('home') }}" class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold text-center hover:bg-gray-300 transition">
                    Hủy
                </a>
                <button type="submit" class="flex-1 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition">
                    Đăng công thức
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('uploadPlaceholder').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection