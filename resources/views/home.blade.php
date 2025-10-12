<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900">Hệ thống quản lý</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm text-gray-600">
                            Xin chào, <strong>{{ auth()->user()->name }}</strong>
                            ({{ auth()->user()->getRoleLabel() }})
                        </span>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="/admin" class="bg-red-600 text-white px-3 py-2 rounded-md text-sm hover:bg-red-700">
                                Admin Panel
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-gray-600 text-white px-3 py-2 rounded-md text-sm hover:bg-gray-700">
                                Đăng xuất
                            </button>
                        </form>
                    @else
                        <a href="/login" class="bg-blue-600 text-white px-3 py-2 rounded-md text-sm hover:bg-blue-700">
                            Đăng nhập
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Chào mừng!</h2>
                    
                    @auth
                        <div class="space-y-4">
                            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                <h3 class="text-green-800 font-medium">Thông tin tài khoản</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p><strong>Tên:</strong> {{ auth()->user()->name }}</p>
                                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                    <p><strong>Vai trò:</strong> {{ auth()->user()->getRoleLabel() }}</p>
                                </div>
                            </div>

                            @if(auth()->user()->hasRole('admin'))
                                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                    <h3 class="text-red-800 font-medium">Quyền Admin</h3>
                                    <p class="mt-2 text-sm text-red-700">
                                        Bạn có quyền truy cập admin panel.
                                    </p>
                                    <a href="/admin" class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                        Vào Admin Panel
                                    </a>
                                </div>
                            @elseif(auth()->user()->hasRole('ctv'))
                                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                    <h3 class="text-yellow-800 font-medium">Cộng tác viên</h3>
                                    <p class="mt-2 text-sm text-yellow-700">
                                        Bạn có thể hỗ trợ khách hàng và quản lý đơn hàng.
                                    </p>
                                </div>
                            @else
                                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                    <h3 class="text-blue-800 font-medium">Khách hàng</h3>
                                    <p class="mt-2 text-sm text-blue-700">
                                        Bạn có thể xem sản phẩm và đặt hàng.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Vui lòng đăng nhập để sử dụng hệ thống.</p>
                            <a href="/login" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Đăng nhập ngay
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</body>
</html>