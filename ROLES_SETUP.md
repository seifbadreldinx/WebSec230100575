# Role-Based Access Control Setup

## Overview
The online product store now has a complete role-based access control system with three roles:
- **Admin**: Administrator with full system access
- **Customer**: Customer who can browse and purchase products
- **Employee**: Employee who can manage products and orders

## Database Structure

### Roles Table
- `id`: Primary key
- `name`: Role name (unique)
- `description`: Role description
- `created_at`, `updated_at`: Timestamps

### Users Table Enhancement
- Added `role_id` foreign key to link users with their roles

## Files Created/Modified

### 1. Models
- **`app/Models/Role.php`**: Role model with relationship to users
- **`app/Models/User.php`**: Enhanced with role relationship and helper methods

### 2. Migrations
- **`database/migrations/2025_11_03_204019_create_roles_table.php`**: Creates roles table
- **`database/migrations/2025_11_03_204241_add_role_id_to_users_table.php`**: Adds role_id to users table

### 3. Seeders
- **`database/seeders/RoleSeeder.php`**: Seeds Admin, Customer, and Employee roles
- **`database/seeders/DatabaseSeeder.php`**: Updated to call RoleSeeder

### 4. Middleware
- **`app/Http/Middleware/CheckRole.php`**: Middleware to check user roles
- **`app/Http/Kernel.php`**: Registered 'role' middleware

## Usage Examples

### 1. Assign Role to User
```php
use App\Models\User;
use App\Models\Role;

// Get a role
$adminRole = Role::where('name', 'Admin')->first();
$customerRole = Role::where('name', 'Customer')->first();
$employeeRole = Role::where('name', 'Employee')->first();

// Assign role to user
$user = User::find(1);
$user->role_id = $adminRole->id;
$user->save();
```

### 2. Check User Role
```php
$user = auth()->user();

// Using helper methods
if ($user->isAdmin()) {
    // Admin-specific logic
}

if ($user->isCustomer()) {
    // Customer-specific logic
}

if ($user->isEmployee()) {
    // Employee-specific logic
}

// Using generic hasRole method
if ($user->hasRole('Admin')) {
    // Admin-specific logic
}
```

### 3. Protect Routes with Middleware
```php
// In routes/web.php

// Admin only routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/users', [AdminController::class, 'users']);
});

// Employee routes
Route::middleware(['auth', 'role:Employee'])->group(function () {
    Route::get('/employee/products', [EmployeeController::class, 'products']);
    Route::get('/employee/orders', [EmployeeController::class, 'orders']);
});

// Customer routes
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/shop', [ShopController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
});

// Multiple roles allowed
Route::middleware(['auth', 'role:Admin,Employee'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
});
```

### 4. Access Role Information
```php
$user = auth()->user();

// Get role name
$roleName = $user->role->name;

// Get role description
$roleDescription = $user->role->description;

// Get all users with a specific role
$admins = Role::where('name', 'Admin')->first()->users;
```

## Next Steps

To complete your online product store, you might want to:

1. **Create Controllers**:
   - `AdminController` for admin functions
   - `EmployeeController` for employee functions
   - `ShopController` for customer shopping
   - `ProductController` for product management

2. **Create Products System**:
   - Products table and model
   - Categories table and model
   - Product images
   - Inventory management

3. **Create Orders System**:
   - Orders table and model
   - Order items
   - Shopping cart functionality
   - Payment processing

4. **Create Views**:
   - Admin dashboard
   - Employee product management
   - Customer shop interface
   - Product catalog
   - Checkout process

5. **Add Authentication**:
   - Registration with role assignment
   - Login/Logout
   - Password reset

## Testing

To test the roles system:

```bash
# Run migrations and seed roles
php artisan migrate:fresh --seed

# Create a test admin user in tinker
php artisan tinker
>>> $admin = User::create(['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
>>> $adminRole = Role::where('name', 'Admin')->first();
>>> $admin->role_id = $adminRole->id;
>>> $admin->save();

# Create a test customer
>>> $customer = User::create(['name' => 'Customer User', 'email' => 'customer@example.com', 'password' => bcrypt('password')]);
>>> $customerRole = Role::where('name', 'Customer')->first();
>>> $customer->role_id = $customerRole->id;
>>> $customer->save();
```

## Summary

✅ **Roles Table Created**: Admin, Customer, Employee roles are defined
✅ **User-Role Relationship**: Users can be assigned roles via role_id
✅ **Role Model**: Complete model with relationships
✅ **User Helper Methods**: `isAdmin()`, `isCustomer()`, `isEmployee()`, `hasRole()`
✅ **Role Middleware**: Protect routes based on user roles
✅ **Database Seeded**: All three roles are seeded in the database

Your role-based access control system is now ready to use!
