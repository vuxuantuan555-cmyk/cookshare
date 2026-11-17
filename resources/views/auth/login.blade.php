@extends('layouts.app')

@section('title', 'Đăng nhập - CookShare')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md slide-up">
        <div class="text-center mb-8">
            <span class="text-5xl">🍳</span>
            <h1 class="font-script text-3xl text-orange-600 mt-2">CookShare</h1>
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Đăng nhập</h2>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="email@example.com">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Mật khẩu</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="••••••••">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 mr-2 accent-orange-500">
                <label for="remember" class="text-gray-600">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" class="w-full py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition">
                Đăng nhập
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            Chưa có tài khoản? 
            <a href="{{ route('register') }}" class="text-orange-600 font-medium hover:underline">Đăng ký ngay</a>
        </p>
    </div>
</div>
@endsection