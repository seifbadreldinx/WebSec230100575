<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees - Admin</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
            border: 1px solid #667eea;
            border-radius: 5px;
            text-decoration: none;
            color: #667eea;
        }
        .pagination .active {
            background: #667eea;
            color: white;
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
                👤 <?php echo e(auth()->user()->name); ?>

            </div>
            <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
            <a href="<?php echo e(route('admin.employees')); ?>">Employees</a>
            <a href="<?php echo e(route('admin.users')); ?>">Users</a>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>👥 Employee Management</h2>
            <a href="<?php echo e(route('admin.employees.create')); ?>" class="btn btn-primary">➕ Add Employee</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                ✅ <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                ❌ <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="table-container">
            <?php if($employees->count() > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#<?php echo e($employee->id); ?></td>
                                <td><?php echo e($employee->name); ?></td>
                                <td><?php echo e($employee->email); ?></td>
                                <td><?php echo e($employee->created_at->format('Y-m-d')); ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?php echo e(route('admin.employees.edit', $employee->id)); ?>" class="btn btn-edit">✏️ Edit</a>
                                        <form action="<?php echo e(route('admin.employees.destroy', $employee->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-delete">🗑️ Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <?php echo e($employees->links()); ?>

                </div>
            <?php else: ?>
                <p style="text-align: center; padding: 40px; color: #666;">No employees found. <a href="<?php echo e(route('admin.employees.create')); ?>" style="color: #667eea;">Add one now</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\MidTerm230100575\resources\views/admin/employees/index.blade.php ENDPATH**/ ?>