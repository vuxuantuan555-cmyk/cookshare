@extends('layouts.app')

@section('title', 'Chỉnh sửa công thức - CookShare')

@section('content')
<div style="max-width: 672px; margin: 0 auto; padding: 32px 16px;">
    <div style="background-color: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); padding: 32px;">
        <h1 style="font-size: 24px; font-weight: bold; color: #1f2937; margin-bottom: 24px;">Chỉnh sửa công thức</h1>

        <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Tên món ăn *</label>
                <input type="text" name="name" value="{{ old('name', $recipe->name) }}" required
                    style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; box-sizing: border-box;">
                @error('name')
                    <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Danh mục *</label>
                <select name="category" required 
                    style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; box-sizing: border-box; background: white;">
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $recipe->category) === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Thời gian nấu *</label>
                    <input type="text" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" required
                        style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; box-sizing: border-box;">
                    @error('cook_time')
                        <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Khẩu phần *</label>
                    <input type="text" name="servings" value="{{ old('servings', $recipe->servings) }}" required
                        style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; box-sizing: border-box;">
                    @error('servings')
                        <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Mô tả ngắn</label>
                <textarea name="description" rows="2"
                    style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; box-sizing: border-box; resize: vertical;">{{ old('description', $recipe->description) }}</textarea>
                @error('description')
                    <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Hình ảnh món ăn</label>
                @if($recipe->image)
                    <div style="margin-bottom: 12px;">
                        @if(Str::startsWith($recipe->image, 'http'))
                            <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" style="max-height: 192px; border-radius: 8px;">
                        @else
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}" style="max-height: 192px; border-radius: 8px;">
                        @endif
                        <p style="font-size: 14px; color: #6b7280; margin-top: 4px;">Ảnh hiện tại</p>
                    </div>
                @endif
                <div style="border: 2px dashed #d1d5db; border-radius: 8px; padding: 24px; text-align: center; position: relative; cursor: pointer;">
                    <input type="file" name="image" accept="image/*" 
                        style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                    <svg style="width: 48px; height: 48px; margin: 0 auto 8px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p style="color: #6b7280;">Nhấp để thay đổi ảnh (tối đa 5MB)</p>
                </div>
                @error('image')
                    <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Nguyên liệu * (mỗi dòng một nguyên liệu)</label>
                <textarea name="ingredients" rows="5" required
                    style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; box-sizing: border-box; resize: vertical;">{{ old('ingredients', implode("\n", $recipe->ingredients)) }}</textarea>
                @error('ingredients')
                    <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; color: #374151; font-weight: 500; margin-bottom: 8px;">Các bước thực hiện * (mỗi dòng một bước)</label>
                <textarea name="steps" rows="6" required
                    style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; box-sizing: border-box; resize: vertical;">{{ old('steps', implode("\n", $recipe->steps)) }}</textarea>
                @error('steps')
                    <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 16px;">
                <a href="{{ route('recipes.show', $recipe) }}" style="flex: 1; padding: 12px; background-color: #e5e7eb; color: #374151; border-radius: 8px; font-weight: 600; text-align: center; text-decoration: none;">
                    Hủy
                </a>
                <button type="submit" style="flex: 1; padding: 12px; background-color: #f97316; color: white; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; font-size: 16px;">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection