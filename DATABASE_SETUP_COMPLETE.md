# Online Product Store - Database Setup Complete

## Overview
A complete Laravel-based online product store with role-based access control and full e-commerce database structure.

---

## Database Tables Created

### 1. **roles**
Stores the three user roles for the system.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Role name (Admin, Customer, Employee) |
| description | text | Role description |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

**Seeded Data:**
- Admin - Administrator with full system access
- Customer - Customer who can browse and purchase products
- Employee - Employee who can manage products and orders

---

### 2. **users**
Stores all user accounts with role assignments.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | User's full name |
| email | varchar | User's email (unique) |
| password | varchar | Hashed password |
| role_id | bigint | Foreign key to roles table |
| email_verified_at | timestamp | Email verification timestamp |
| remember_token | varchar | Remember me token |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

**Default Users Created:**
- **Admin:** admin@example.com / password
- **Employee:** employee@example.com / password
- **Customer:** customer@example.com / password

---

### 3. **categories**
Product categories for organizing items.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Category name |
| description | text | Category description |
| slug | varchar | URL-friendly identifier (unique) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

**Seeded Categories:**
- Electronics
- Clothing
- Books
- Home & Garden
- Sports & Outdoors

---

### 4. **products**
All product information for the store.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Product name |
| description | text | Product description |
| price | decimal(10,2) | Product price |
| stock | integer | Available quantity |
| image | varchar | Product image path |
| category_id | bigint | Foreign key to categories |
| is_active | boolean | Product active status |
| sku | varchar | Stock keeping unit (unique) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

---

### 5. **orders**
Customer order information.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users |
| order_number | varchar | Unique order identifier |
| total_amount | decimal(10,2) | Total order amount |
| status | enum | Order status (pending, processing, shipped, delivered, cancelled) |
| shipping_address | varchar | Shipping street address |
| shipping_city | varchar | Shipping city |
| shipping_postal_code | varchar | Shipping postal code |
| shipping_country | varchar | Shipping country |
| phone | varchar | Contact phone number |
| notes | text | Order notes |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

---

### 6. **order_items**
Individual items within each order.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| order_id | bigint | Foreign key to orders |
| product_id | bigint | Foreign key to products |
| quantity | integer | Quantity ordered |
| price | decimal(10,2) | Price at time of order |
| subtotal | decimal(10,2) | Line item total (quantity × price) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

---

### 7. **cart**
Shopping cart items for logged-in users.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users |
| product_id | bigint | Foreign key to products |
| quantity | integer | Quantity in cart |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

---

## Models Created

### 1. **Role Model**
- `app/Models/Role.php`
- Relationships: `hasMany(User)`

### 2. **User Model**
- `app/Models/User.php`
- Relationships: `belongsTo(Role)`, `hasMany(Order)`, `hasMany(Cart)`
- Helper Methods:
  - `hasRole($roleName)` - Check if user has specific role
  - `isAdmin()` - Check if user is admin
  - `isCustomer()` - Check if user is customer
  - `isEmployee()` - Check if user is employee

### 3. **Category Model**
- `app/Models/Category.php`
- Relationships: `hasMany(Product)`

### 4. **Product Model**
- `app/Models/Product.php`
- Relationships: `belongsTo(Category)`, `hasMany(OrderItem)`, `hasMany(Cart)`

### 5. **Order Model**
- `app/Models/Order.php`
- Relationships: `belongsTo(User)`, `hasMany(OrderItem)`
- Static Method: `generateOrderNumber()` - Generate unique order numbers

### 6. **OrderItem Model**
- `app/Models/OrderItem.php`
- Relationships: `belongsTo(Order)`, `belongsTo(Product)`

### 7. **Cart Model**
- `app/Models/Cart.php`
- Relationships: `belongsTo(User)`, `belongsTo(Product)`

---

## Controllers Created

### 1. **RegisterController**
- `app/Http/Controllers/Auth/RegisterController.php`
- **Auto-assigns Customer role** to new registrations
- Methods:
  - `showRegistrationForm()` - Display registration form
  - `register()` - Handle registration and auto-assign Customer role

### 2. **LoginController**
- `app/Http/Controllers/Auth/LoginController.php`
- Redirects users based on their role after login
- Methods:
  - `showLoginForm()` - Display login form
  - `login()` - Handle login with role-based redirects
  - `logout()` - Handle logout

### 3. **AdminController**
- `app/Http/Controllers/AdminController.php`
- **Protected by 'role:Admin' middleware**
- Admin can add, edit, and delete employees internally
- Methods:
  - `dashboard()` - Admin dashboard
  - `employees()` - List all employees
  - `createEmployee()` - Show employee creation form
  - `storeEmployee()` - **Add new employee (Admin only)**
  - `editEmployee()` - Show employee edit form
  - `updateEmployee()` - Update employee details
  - `destroyEmployee()` - Delete employee
  - `users()` - View all users

---

## Routes Configured

### Authentication Routes (Guest Only)
```php
GET  /register         - Registration form
POST /register         - Process registration (auto-assigns Customer role)
GET  /login            - Login form
POST /login            - Process login
```

### Auth Routes
```php
POST /logout           - Logout
```

### Admin Routes (Admin Role Required)
```php
GET    /admin/dashboard              - Admin dashboard
GET    /admin/employees              - List employees
GET    /admin/employees/create       - Create employee form
POST   /admin/employees              - Store new employee
GET    /admin/employees/{id}/edit    - Edit employee form
PUT    /admin/employees/{id}         - Update employee
DELETE /admin/employees/{id}         - Delete employee
GET    /admin/users                  - View all users
```

---

## Middleware

### CheckRole Middleware
- `app/Http/Middleware/CheckRole.php`
- Registered as 'role' in `app/Http/Kernel.php`
- Usage: `->middleware('role:Admin,Employee')`
- Checks if authenticated user has required role(s)

---

## Key Features Implemented

### ✅ Role-Based Access Control
- Three roles: Admin, Customer, Employee
- Middleware protection for routes
- Helper methods on User model

### ✅ Registration System
- **New users automatically assigned Customer role**
- Email validation
- Password confirmation
- Unique email requirement

### ✅ Admin Employee Management
- **Admin can add employees internally**
- Admin can edit employee details
- Admin can delete employees
- Admin can view all users

### ✅ Complete E-commerce Database
- Products with categories
- Shopping cart system
- Order management with line items
- Inventory tracking (stock field)

### ✅ Database Relationships
- User → Role
- User → Orders
- User → Cart Items
- Product → Category
- Order → Order Items
- Order Items → Products

---

## Database Seeders

### 1. RoleSeeder
Seeds the three roles: Admin, Customer, Employee

### 2. AdminUserSeeder
Creates default users:
- Admin user (admin@example.com)
- Employee user (employee@example.com)
- Customer user (customer@example.com)

### 3. CategorySeeder
Seeds 5 product categories

---

## Testing the System

### 1. Login as Admin
```
Email: admin@example.com
Password: password
```
- Access `/admin/dashboard`
- Add new employees at `/admin/employees/create`
- Manage existing employees

### 2. Register as Customer
- Go to `/register`
- Fill in registration form
- **Customer role is automatically assigned**
- Login and shop

### 3. Login as Employee
```
Email: employee@example.com
Password: password
```
- Can be given access to product management
- Can view and process orders

---

## User Factory Configuration

The `UserFactory` has been configured to automatically assign the **Customer role** when creating users:

```php
// database/factories/UserFactory.php
public function definition()
{
    $customerRole = Role::where('name', 'Customer')->first();
    
    return [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password'),
        'role_id' => $customerRole ? $customerRole->id : null,
    ];
}
```

---

## Next Steps

To complete the online product store, you can:

1. **Create Product Management Views**
   - Admin/Employee can add/edit products
   - Product listing page
   - Product detail pages

2. **Implement Shopping Cart**
   - Add to cart functionality
   - View cart
   - Update quantities
   - Remove items

3. **Checkout Process**
   - Shipping information form
   - Order review
   - Payment integration
   - Order confirmation

4. **Customer Features**
   - Product browsing
   - Search and filtering
   - Order history
   - Profile management

5. **Employee Features**
   - Product inventory management
   - Order processing
   - Order status updates

6. **Admin Reports**
   - Sales reports
   - User statistics
   - Product performance

---

## Summary

✅ **Complete database schema** for e-commerce
✅ **Three roles**: Admin, Customer, Employee
✅ **Auto-assign Customer role** on registration
✅ **Admin can add employees** internally via admin panel
✅ **All models and relationships** configured
✅ **Authentication system** with role-based redirects
✅ **Middleware protection** for admin routes
✅ **Sample data seeded** for testing

Your online product store database is fully set up and ready for frontend development! 🚀
