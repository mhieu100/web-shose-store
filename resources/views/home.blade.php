<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Shoe Store') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-800">👟 Shoe Store</h1>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-600 hover:text-gray-900">Home</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900">Products</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900">About</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/admin" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Admin Panel
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="text-center">
                <h2 class="text-5xl font-bold mb-6">Welcome to Our Shoe Store</h2>
                <p class="text-xl mb-8">Discover the perfect pair of shoes for every occasion</p>
                <div class="space-x-4">
                    <a href="#products" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Shop Now
                    </a>
                    <a href="#about" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="products" class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-800 mb-4">Why Choose Us?</h3>
                <p class="text-gray-600 max-w-2xl mx-auto">We offer the best selection of shoes with unmatched quality and customer service</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white rounded-lg shadow-md">
                    <div class="text-4xl mb-4">👟</div>
                    <h4 class="text-xl font-semibold mb-2">Premium Quality</h4>
                    <p class="text-gray-600">High-quality materials and craftsmanship in every pair</p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-md">
                    <div class="text-4xl mb-4">🚚</div>
                    <h4 class="text-xl font-semibold mb-2">Fast Shipping</h4>
                    <p class="text-gray-600">Quick delivery to your doorstep with tracking</p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-md">
                    <div class="text-4xl mb-4">💯</div>
                    <h4 class="text-xl font-semibold mb-2">Satisfaction Guarantee</h4>
                    <p class="text-gray-600">30-day return policy for your peace of mind</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center">
                <h3 class="text-3xl font-bold text-gray-800 mb-8">About Our Store</h3>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-8">
                    We've been serving customers with the finest selection of shoes for over a decade.
                    Our commitment to quality, style, and comfort has made us a trusted name in footwear.
                </p>
                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h4 class="text-xl font-semibold mb-3">Our Mission</h4>
                        <p class="text-gray-600">To provide comfortable, stylish, and affordable footwear for everyone.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h4 class="text-xl font-semibold mb-3">Our Vision</h4>
                        <p class="text-gray-600">To be the leading shoe retailer known for quality and customer satisfaction.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-lg font-semibold mb-4">Shoe Store</h5>
                    <p class="text-gray-400">Your trusted partner for quality footwear.</p>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Home</a></li>
                        <li><a href="#" class="hover:text-white">Products</a></li>
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Categories</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Men's Shoes</a></li>
                        <li><a href="#" class="hover:text-white">Women's Shoes</a></li>
                        <li><a href="#" class="hover:text-white">Kids' Shoes</a></li>
                        <li><a href="#" class="hover:text-white">Sports Shoes</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Contact Info</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li>📧 info@shoestore.com</li>
                        <li>📞 +1 (555) 123-4567</li>
                        <li>📍 123 Shoe Street, City</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Shoe Store. All rights reserved. | <a href="/admin" class="text-blue-400 hover:text-blue-300">Admin Panel</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
