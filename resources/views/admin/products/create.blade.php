<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product - Employee</title>
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
            max-width: 800px;
            margin: 0 auto;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-header {
            margin-bottom: 30px;
        }
        .form-header h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #28a745;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .form-group .help-text {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .form-group-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-group-checkbox input[type="checkbox"] {
            width: auto;
            cursor: pointer;
        }
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
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
        <div class="form-container">
            <div class="form-header">
                <h2>➕ Create New Product</h2>
                <a href="{{ route('admin.products') }}" style="color: #28a745; text-decoration: none;">← Back to Products</a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Product Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           placeholder="Enter product name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" 
                              id="description" 
                              placeholder="Enter product description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id">
                        <option value="">Select a category (optional)</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price *</label>
                    <input type="number" 
                           name="price" 
                           id="price" 
                           step="0.01" 
                           min="0" 
                           placeholder="0.00"
                           value="{{ old('price') }}"
                           required>
                    @error('price')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Enter price in dollars (e.g., 99.99)</div>
                </div>

                <div class="form-group">
                    <label for="stock">Stock Quantity *</label>
                    <input type="number" 
                           name="stock" 
                           id="stock" 
                           min="0" 
                           placeholder="0"
                           value="{{ old('stock', 0) }}"
                           required>
                    @error('stock')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Number of items available in stock</div>
                </div>

                <div class="form-group">
                    <label for="sku">SKU (Stock Keeping Unit)</label>
                    <input type="text" 
                           name="sku" 
                           id="sku" 
                           placeholder="Enter SKU (optional)"
                           value="{{ old('sku') }}">
                    @error('sku')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Unique identifier for the product (optional)</div>
                </div>

                <div class="form-group form-group-checkbox">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" style="margin: 0; font-weight: normal;">Product is active</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        ➕ Create Product
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>



