<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 10px;
        }
        .stat-card p {
            color: #666;
            font-size: 1.1rem;
        }
        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .quick-actions h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .action-btn {
            display: block;
            padding: 15px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h1>👨‍💼 Admin Dashboard</h1>
        </div>
        <div class="navbar-links">
            <div class="user-info">
                👤 {{ auth()->user()->name }} (Admin)
            </div>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('admin.employees') }}">Employees</a>
            <a href="{{ route('admin.users') }}">Users</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['total_customers'] }}</h3>
                <p>Customers</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['total_employees'] }}</h3>
                <p>Employees</p>
            </div>
        </div>

        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="{{ route('admin.employees.create') }}" class="action-btn">➕ Add Employee</a>
                <a href="{{ route('admin.employees') }}" class="action-btn">👥 Manage Employees</a>
                <a href="{{ route('admin.customers') }}" class="action-btn">� Manage Customers</a>
                <a href="{{ route('admin.products') }}" class="action-btn">� Manage Products</a>
                <a href="{{ route('admin.users') }}" class="action-btn">📋 View All Users</a>
                <a href="{{ route('admin.roles') }}" class="action-btn">� View Roles & Permissions</a>
            </div>
        </div>
    </div>
</body>
</html>
