<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Online Store</title>
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
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .product-name {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .product-category {
            color: #667eea;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .product-description {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #27ae60;
        }
        .product-stock {
            color: #666;
            font-size: 0.9rem;
        }
        .product-sku {
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .pagination a, .pagination span {
            padding: 8px 15px;
            border: 1px solid #667eea;
            border-radius: 5px;
            text-decoration: none;
            color: #667eea;
        }
        .pagination .active {
            background: #667eea;
            color: white;
        }
        .no-products {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .no-products h2 {
            color: #666;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h1>🛍️ Product Store</h1>
        </div>
        <div class="navbar-links">
            <?php if(auth()->guard()->check()): ?>
                <div class="user-info">
                    👤 <?php echo e(auth()->user()->name); ?>

                    <?php if(auth()->user() && auth()->user()->isCustomer()): ?>
                        | 💳 Credit: <span class="credit-display">$<?php echo e(number_format(auth()->user()->credit, 2)); ?></span>
                    <?php endif; ?>
                </div>
                <?php if(auth()->user() && auth()->user()->isCustomer()): ?>
                    <a href="<?php echo e(route('products.my-purchases')); ?>">My Purchases</a>
                <?php endif; ?>
                <?php if(auth()->user() && auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>">Admin Dashboard</a>
                <?php endif; ?>
                <?php if(auth()->user() && auth()->user()->isEmployee()): ?>
                    <a href="<?php echo e(route('employee.dashboard')); ?>">Employee Dashboard</a>
                <?php endif; ?>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                ✅ <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-error">
                ❌ <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($products->count() > 0): ?>
            <div class="products-grid">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-card">
                        <div class="product-name"><?php echo e($product->name); ?></div>
                        <div class="product-category">📁 <?php echo e($product->category->name); ?></div>
                        <div class="product-description"><?php echo e($product->description); ?></div>
                        <div class="product-sku">SKU: <?php echo e($product->sku); ?></div>
                        <div class="product-info">
                            <div class="product-price">$<?php echo e(number_format($product->price, 2)); ?></div>
                            <div class="product-stock">
                                <?php if($product->stock > 10): ?>
                                    ✅ In Stock: <?php echo e($product->stock); ?>

                                <?php elseif($product->stock > 0): ?>
                                    ⚠️ Low Stock: <?php echo e($product->stock); ?>

                                <?php else: ?>
                                    ❌ Out of Stock
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if(auth()->check() && auth()->user()->isCustomer()): ?>
                            <?php if($product->stock > 0): ?>
                                <form action="<?php echo e(route('products.buy', $product->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary">
                                        🛒 Buy Now
                                    </button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Out of Stock</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-secondary">
                                View Details
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="pagination">
                <?php echo e($products->links()); ?>

            </div>
        <?php else: ?>
            <div class="no-products">
                <h2>No Products Available</h2>
                <p>Check back later for new products!</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\MidTerm230100575\resources\views/products/index.blade.php ENDPATH**/ ?>