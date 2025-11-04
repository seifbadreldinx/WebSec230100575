<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - Employee</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        .container {
            max-width: 1400px;
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
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #333;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .btn-edit {
            background: #007bff;
            color: white;
            padding: 6px 12px;
            font-size: 0.9rem;
        }
        .btn-edit:hover {
            background: #0056b3;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            font-size: 0.9rem;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .btn-success {
            background: #28a745;
            color: white;
            padding: 6px 12px;
            font-size: 0.9rem;
        }
        .btn-success:hover {
            background: #218838;
        }
        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: #f8f9fa;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            font-weight: 600;
            color: #333;
        }
        tbody tr:hover {
            background: #f8f9fa;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        .stock-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .stock-high {
            background: #d4edda;
            color: #155724;
        }
        .stock-low {
            background: #fff3cd;
            color: #856404;
        }
        .stock-out {
            background: #f8d7da;
            color: #721c24;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .pagination a, .pagination span {
            padding: 8px 15px;
            border: 1px solid #28a745;
            border-radius: 5px;
            text-decoration: none;
            color: #28a745;
        }
        .pagination .active {
            background: #28a745;
            color: white;
        }
        .stock-form {
            display: inline-flex;
            gap: 5px;
            align-items: center;
        }
        .stock-form input {
            width: 80px;
            padding: 4px 8px;
            border: 1px solid #dee2e6;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h1>👔 Employee Dashboard</h1>
        </div>
        <div class="navbar-links">
            <div class="user-info">
                👤 {{ auth()->user()->name }}
            </div>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.customers') }}">Customers</a>
            <a href="{{ route('admin.products') }}">Products</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>📦 Product Management</h2>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="background: #6c757d; margin-right: 10px;">← Back</a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">➕ Add New Product</a>
            </div>
        </div>

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

        <div class="table-container">
            @if($products->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>SKU</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>#{{ $product->id }}</td>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span class="stock-badge 
                                        @if($product->stock > 10) stock-high
                                        @elseif($product->stock > 0) stock-low
                                        @else stock-out @endif">
                                        {{ $product->stock }} units
                                    </span>
                                    <form action="{{ route('admin.products.update-stock', $product->id) }}" method="POST" class="stock-form" style="margin-left: 10px;">
                                        @csrf
                                        <input type="number" name="stock" value="{{ $product->stock }}" min="0" required>
                                        <button type="submit" class="btn btn-success" style="padding: 4px 8px; font-size: 0.85rem;">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <span class="status-badge {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $product->sku ?? 'N/A' }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-edit">✏️ Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">🗑️ Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $products->links() }}
                </div>
            @else
                <p style="text-align: center; padding: 40px; color: #666;">No products found. <a href="{{ route('admin.products.create') }}" style="color: #28a745;">Create one now</a></p>
            @endif
        </div>
    </div>
</body>
</html>



