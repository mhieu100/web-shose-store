<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function togglePassword(inputId, eyeId, eyeOffId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeId);
            const eyeOffIcon = document.getElementById(eyeOffId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Đăng ký tài khoản</h1>
            <p class="text-gray-600 mt-2">Tạo tài khoản mới để sử dụng hệ thống</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Họ và tên <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                    placeholder="Nhập họ và tên đầy đủ"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Địa chỉ email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                    placeholder="Nhập email của bạn"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Số điện thoại
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                    placeholder="Nhập số điện thoại (tùy chọn)"
                >
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Địa chỉ
                </label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror"
                    placeholder="Nhập địa chỉ (tùy chọn)"
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Mật khẩu <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                        placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('password', 'eye-icon', 'eye-off-icon')" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                    >
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Xác nhận mật khẩu <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Nhập lại mật khẩu để xác nhận"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('password_confirmation', 'eye-icon-confirm', 'eye-off-icon-confirm')" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                    >
                        <svg id="eye-icon-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-off-icon-confirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200"
            >
                Đăng ký tài khoản
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Đã có tài khoản? 
                <a href="/login" class="text-blue-600 hover:text-blue-800 font-medium">
                    Đăng nhập ngay
                </a>
            </p>
        </div>
    </div>
</body>
</html>