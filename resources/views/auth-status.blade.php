<!DOCTYPE html>
<html>
<head>
    <title>Auth Status Check</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .status { padding: 20px; border-radius: 5px; margin: 20px 0; }
        .logged-in { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .logged-out { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>🔐 Authentication Status Check</h1>
    
    @auth
        <div class="status logged-in">
            <h2>✅ Bạn đã đăng nhập thành công!</h2>
            <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Role ID:</strong> {{ Auth::user()->role_id }}</p>
            
            <hr>
            <h3>🧪 Test Middleware:</h3>
            <p>
                <a href="{{ route('login') }}" target="_blank">
                    Thử truy cập /login
                </a> 
                → Sẽ tự động redirect về trang chủ (/)
            </p>
            
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit">🚪 Đăng xuất</button>
            </form>
        </div>
    @else
        <div class="status logged-out">
            <h2>❌ Bạn chưa đăng nhập</h2>
            <p>
                <a href="{{ route('login') }}">👤 Đăng nhập tại đây</a> 
                hoặc 
                <a href="{{ route('register') }}">📝 Đăng ký tài khoản mới</a>
            </p>
        </div>
    @endauth
    
    <hr>
    <h3>📊 Debug Info:</h3>
    <p><strong>Current Route:</strong> {{ Request::url() }}</p>
    <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
    <p><strong>Auth Check:</strong> {{ Auth::check() ? 'true' : 'false' }}</p>
    
    <div style="margin-top: 30px;">
        <a href="{{ route('home') }}">🏠 Về trang chủ</a> | 
        <a href="{{ route('wishlist') }}">💝 Wishlist</a> |
        <a href="{{ route('shop') }}">🛍️ Shop</a>
    </div>
</body>
</html>