<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insufficient Credit</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }
        .icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        h1 {
            color: #e74c3c;
            margin-bottom: 20px;
            font-size: 2rem;
        }
        .product-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
        .product-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            color: #666;
            font-weight: 600;
        }
        .value {
            font-weight: bold;
        }
        .value.price {
            color: #27ae60;
            font-size: 1.2rem;
        }
        .value.current {
            color: #e74c3c;
            font-size: 1.2rem;
        }
        .value.shortage {
            color: #e74c3c;
            font-size: 1.3rem;
        }
        .message {
            color: #666;
            margin: 20px 0;
            font-size: 1.1rem;
        }
        .buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">💳❌</div>
        <h1>Insufficient Credit!</h1>
        
        <p class="message">Sorry, you don't have enough credit to purchase this product.</p>

        <div class="product-info">
            <div class="product-name">{{ $product->name }}</div>
            
            <div class="info-row">
                <span class="label">Product Price:</span>
                <span class="value price">${{ number_format($required, 2) }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Your Current Credit:</span>
                <span class="value current">${{ number_format($current, 2) }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">You Need:</span>
                <span class="value shortage">${{ number_format($shortage, 2) }}</span>
            </div>
        </div>

        <p class="message">Please contact an administrator to add more credit to your account.</p>

        <div class="buttons">
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                ← Back to Products
            </a>
            <a href="{{ route('products.my-purchases') }}" class="btn btn-secondary">
                My Purchases
            </a>
        </div>
    </div>
</body>
</html>
