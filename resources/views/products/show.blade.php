<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Product Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar h1 {
            font-size: 1.8rem;
        }
        .navbar-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .navbar-links a, .navbar-links form {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            background: rgba(255,255,255,0.2);
            transition: background 0.3s;
        }
        .navbar-links a:hover {
            background: rgba(255,255,255,0.3);
        }
        .navbar-links button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1rem;
        }
        .user-info {
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 5px;
        }
        .credit-display {
            font-weight: bold;
            font-size: 1.2rem;
            color: #ffd700;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .back-link:hover {
            transform: translateX(-5px);
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .product-detail {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
        }
        .product-image-section {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 60px;
            color: white;
        }
        .product-icon {
            font-size: 10rem;
        }
        .product-info-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .product-category {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            width: fit-content;
        }
        .product-name {
            font-size: 2.5rem;
            color: #333;
            font-weight: bold;
        }
        .product-description {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .product-price {
            font-size: 3rem;
            color: #27ae60;
            font-weight: bold;
        }
        .product-stock {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            width: fit-content;
        }
        .in-stock {
            background: #d4edda;
            color: #155724;
        }
        .out-of-stock {
            background: #f8d7da;
            color: #721c24;
        }
        .product-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .meta-label {
            color: #666;
            font-size: 0.9rem;
        }
        .meta-value {
            color: #333;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .buy-section {
            margin-top: 20px;
            padding: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            color: white;
        }
        .buy-section h3 {
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .quantity-selector label {
            font-weight: 600;
        }
        .quantity-selector input {
            width: 80px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .btn:disabled:hover {
            transform: none;
        }
        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
            }
            .product-image-section {
                padding: 40px;
            }
            .product-icon {
                font-size: 6rem;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h1>🛍️ Product Details</h1>
        </div>
        <div class="navbar-links">
            @auth
                <div class="user-info">
                    👤 {{ auth()->user()->name }}
                    @if(auth()->user()->isCustomer())
                        | 💳 Credit: <span class="credit-display">${{ number_format(auth()->user()->credit, 2) }}</span>
                    @endif
                </div>
                <a href="{{ route('products.index') }}">Browse Products</a>
                @if(auth()->user()->isCustomer())
                    <a href="{{ route('products.my-purchases') }}">My Purchases</a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                @endif
                @if(auth()->user()->isEmployee())
                    <a href="{{ route('employee.dashboard') }}">Employee Dashboard</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>

    <div class="container">
        <a href="{{ route('products.index') }}" class="back-link">← Back to Products</a>

        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                ❌ {{ session('error') }}
            </div>
        @endif

        <div class="product-detail">
            <div class="product-image-section">
                <div class="product-icon">📦</div>
            </div>

            <div class="product-info-section">
                <div class="product-category">
                    📁 {{ $product->category->name }}
                </div>

                <h1 class="product-name">{{ $product->name }}</h1>

                <p class="product-description">{{ $product->description }}</p>

                <div class="product-price">${{ number_format($product->price, 2) }}</div>

                <div class="product-stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                    @if($product->stock > 0)
                        ✅ In Stock ({{ $product->stock }} available)
                    @else
                        ❌ Out of Stock
                    @endif
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Product ID</span>
                        <span class="meta-value">#{{ $product->id }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Category</span>
                        <span class="meta-value">{{ $product->category->name }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Price</span>
                        <span class="meta-value">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Availability</span>
                        <span class="meta-value">{{ $product->stock }} units</span>
                    </div>
                </div>

                @auth
                    @if(auth()->user()->isCustomer())
                        <div class="buy-section">
                            <h3>💳 Purchase This Product</h3>
                            @if($product->stock > 0)
                                <form action="{{ route('products.buy', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="quantity-selector">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" required>
                                        <span>Max: {{ $product->stock }}</span>
                                    </div>
                                    <button type="submit" class="btn">
                                        🛒 Buy Now - ${{ number_format($product->price, 2) }}
                                    </button>
                                </form>
                            @else
                                <button class="btn" disabled>
                                    ❌ Out of Stock
                                </button>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="buy-section">
                        <h3>Want to buy this product?</h3>
                        <p style="margin-bottom: 15px;">Please log in to make a purchase</p>
                        <a href="{{ route('login') }}" class="btn">
                            🔑 Login to Buy
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
