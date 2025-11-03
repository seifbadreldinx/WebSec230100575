<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Purchases</title>
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
        .purchases-list {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .purchase-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 0;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 20px;
            align-items: center;
        }
        .purchase-item:last-child {
            border-bottom: none;
        }
        .purchase-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .product-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
        }
        .product-category {
            color: #667eea;
            font-size: 0.95rem;
        }
        .purchase-info {
            color: #666;
            font-size: 0.95rem;
        }
        .purchase-date {
            color: #999;
            font-size: 0.9rem;
        }
        .purchase-price {
            text-align: right;
        }
        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 5px;
        }
        .quantity {
            color: #666;
            font-size: 0.9rem;
        }
        .no-purchases {
            text-align: center;
            padding: 60px 20px;
        }
        .no-purchases h2 {
            color: #666;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
        .summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        .summary-item h3 {
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .summary-item p {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h1>📦 My Purchases</h1>
        </div>
        <div class="navbar-links">
            <div class="user-info">
                👤 <?php echo e(auth()->user()->name); ?>

                | 💳 Credit: <span class="credit-display">$<?php echo e(number_format(auth()->user()->credit, 2)); ?></span>
            </div>
            <a href="<?php echo e(route('products.index')); ?>">Browse Products</a>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                ✅ <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="summary">
            <div class="summary-item">
                <h3><?php echo e($purchases->total()); ?></h3>
                <p>Total Purchases</p>
            </div>
            <div class="summary-item">
                <h3>$<?php echo e(number_format($purchases->sum(function($p) { return $p->price_paid * $p->quantity; }), 2)); ?></h3>
                <p>Total Spent</p>
            </div>
            <div class="summary-item">
                <h3>$<?php echo e(number_format(auth()->user()->credit, 2)); ?></h3>
                <p>Remaining Credit</p>
            </div>
        </div>

        <div class="purchases-list">
            <?php if($purchases->count() > 0): ?>
                <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="purchase-item">
                        <div class="purchase-details">
                            <div class="product-name"><?php echo e($purchase->product->name); ?></div>
                            <div class="product-category">📁 <?php echo e($purchase->product->category->name); ?></div>
                            <div class="purchase-info">
                                <?php echo e($purchase->product->description); ?>

                            </div>
                            <div class="purchase-date">
                                🕐 Purchased on <?php echo e($purchase->created_at->format('M d, Y \a\t h:i A')); ?>

                            </div>
                        </div>
                        <div class="purchase-price">
                            <div class="price">$<?php echo e(number_format($purchase->price_paid * $purchase->quantity, 2)); ?></div>
                            <div class="quantity">
                                Quantity: <?php echo e($purchase->quantity); ?> × $<?php echo e(number_format($purchase->price_paid, 2)); ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="pagination">
                    <?php echo e($purchases->links()); ?>

                </div>
            <?php else: ?>
                <div class="no-purchases">
                    <h2>No Purchases Yet</h2>
                    <p style="margin-bottom: 20px;">You haven't bought any products yet. Start shopping now!</p>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn">
                        🛍️ Browse Products
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\MidTerm230100575\resources\views/products/my-purchases.blade.php ENDPATH**/ ?>