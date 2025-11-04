<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charge Credit - Employee</title>
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
        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .customer-info p {
            margin: 5px 0;
            color: #666;
        }
        .customer-info strong {
            color: #333;
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
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #28a745;
        }
        .form-group .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
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
        .note {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
            color: #856404;
        }
        .note strong {
            display: block;
            margin-bottom: 5px;
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
                <h2>💳 Charge Customer Credit</h2>
                <a href="{{ route('admin.customers') }}" style="color: #28a745; text-decoration: none;">← Back to Customers</a>
            </div>

            <div class="customer-info">
                <p><strong>Customer Name:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Current Credit:</strong> <span style="color: #28a745; font-weight: bold; font-size: 1.2rem;">${{ number_format($customer->credit, 2) }}</span></p>
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

            <form action="{{ route('admin.customers.charge-credit.store', $customer->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="amount">Amount to Charge *</label>
                    <input type="number" 
                           name="amount" 
                           id="amount" 
                           step="0.01" 
                           min="0.01" 
                           placeholder="Enter amount (e.g., 100.00)"
                           value="{{ old('amount') }}"
                           required>
                    @error('amount')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="note">
                    <strong>⚠️ Note:</strong>
                    Only positive values are allowed. The amount will be added to the customer's current credit balance.
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        💳 Charge Credit
                    </button>
                    <a href="{{ route('admin.customers') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>



