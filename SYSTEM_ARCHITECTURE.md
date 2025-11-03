# System Architecture Overview

## 🏗️ Database Relationships

```
┌─────────────┐
│   ROLES     │
│  ─────────  │
│ • Admin     │
│ • Customer  │◄────────┐
│ • Employee  │         │
└─────────────┘         │
                        │ role_id (FK)
                        │
                  ┌─────┴──────┐
                  │   USERS    │
                  │ ──────────│
                  │ • name     │
                  │ • email    │
                  │ • password │
                  │ • role_id  │
                  └─────┬──────┘
                        │
            ┌───────────┼───────────┐
            │           │           │
            ▼           ▼           ▼
      ┌─────────┐ ┌─────────┐ ┌─────────┐
      │  CART   │ │ ORDERS  │ │ (More)  │
      └────┬────┘ └────┬────┘ └─────────┘
           │           │
           │           ├───► ORDER_ITEMS ───► PRODUCTS
           │           │
           └───────────┴──────────► PRODUCTS
                                        │
                                        ▼
                                   CATEGORIES
```

---

## 🔄 User Registration Flow

```
┌─────────────────┐
│ User visits     │
│  /register      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Fills form:     │
│ • Name          │
│ • Email         │
│ • Password      │
└────────┬────────┘
         │
         ▼
┌─────────────────────────────┐
│ RegisterController          │
│ @register method            │
│                             │
│ 1. Validate input          │
│ 2. Get Customer role       │◄──── Automatic!
│ 3. Create user with        │
│    role_id = Customer.id   │
│ 4. Login user              │
│ 5. Redirect to home        │
└────────┬────────────────────┘
         │
         ▼
┌─────────────────┐
│ User is now     │
│ logged in as    │
│ 🛍️ CUSTOMER    │
└─────────────────┘
```

---

## 👨‍💼 Admin Adding Employee Flow

```
┌─────────────────┐
│ Admin logs in   │
│ admin@example   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Navigates to    │
│ /admin/employees│
│ /create         │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Fills form:     │
│ • Name          │
│ • Email         │
│ • Password      │
└────────┬────────┘
         │
         ▼
┌─────────────────────────────┐
│ AdminController             │
│ @storeEmployee method       │
│                             │
│ ✓ Middleware checks Admin  │
│ 1. Validate input          │
│ 2. Get Employee role       │◄──── Automatic!
│ 3. Create user with        │
│    role_id = Employee.id   │
│ 4. Redirect to list        │
└────────┬────────────────────┘
         │
         ▼
┌─────────────────┐
│ New employee    │
│ created as      │
│ 👔 EMPLOYEE     │
└─────────────────┘
```

---

## 🔐 Middleware Protection

```
Request → /admin/employees/create
   │
   ▼
┌────────────────────┐
│ auth middleware    │◄─── Is user logged in?
└─────────┬──────────┘
          │ ✓ Yes
          ▼
┌────────────────────┐
│ role:Admin         │◄─── Does user have Admin role?
│ middleware         │
└─────────┬──────────┘
          │ ✓ Yes
          ▼
┌────────────────────┐
│ AdminController    │
│ @createEmployee    │
└────────────────────┘

If No at any step → Redirect/403 Error
```

---

## 📊 Role Distribution

```
┌────────────────────────────────────┐
│         USER ROLES                 │
├────────────────────────────────────┤
│                                    │
│  👨‍💼 ADMIN (1)                     │
│  ├─ Full system access            │
│  ├─ Manage employees              │
│  ├─ Manage all users              │
│  ├─ View all orders               │
│  └─ System configuration          │
│                                    │
│  👔 EMPLOYEE (1+)                  │
│  ├─ Manage products               │
│  ├─ Process orders                │
│  ├─ Update inventory              │
│  └─ View customer info            │
│                                    │
│  🛍️ CUSTOMER (Many)               │
│  ├─ Browse products               │
│  ├─ Add to cart                   │
│  ├─ Place orders                  │
│  ├─ View order history            │
│  └─ Manage profile                │
│                                    │
└────────────────────────────────────┘
```

---

## 🛣️ Route Access Matrix

| Route | Admin | Employee | Customer | Guest |
|-------|-------|----------|----------|-------|
| `/` (Home) | ✅ | ✅ | ✅ | ✅ |
| `/register` | ❌ | ❌ | ❌ | ✅ |
| `/login` | ❌ | ❌ | ❌ | ✅ |
| `/logout` | ✅ | ✅ | ✅ | ❌ |
| `/admin/*` | ✅ | ❌ | ❌ | ❌ |
| `/admin/employees/create` | ✅ | ❌ | ❌ | ❌ |
| `/employee/*` | ✅ | ✅ | ❌ | ❌ |
| `/shop` | ✅ | ✅ | ✅ | ✅ |
| `/cart` | ❌ | ❌ | ✅ | ❌ |
| `/checkout` | ❌ | ❌ | ✅ | ❌ |

---

## 💾 Database Schema Summary

```
USERS Table
├─ id (PK)
├─ name
├─ email (unique)
├─ password (hashed)
├─ role_id (FK → roles.id)  ◄── Links to role
└─ timestamps

ROLES Table
├─ id (PK)
├─ name (unique)
│  ├─ "Admin"     ◄── Full access
│  ├─ "Customer"  ◄── Shopping only
│  └─ "Employee"  ◄── Management
├─ description
└─ timestamps

PRODUCTS Table
├─ id (PK)
├─ name
├─ description
├─ price (decimal)
├─ stock (integer)
├─ image
├─ category_id (FK → categories.id)
├─ is_active (boolean)
├─ sku (unique)
└─ timestamps

ORDERS Table
├─ id (PK)
├─ user_id (FK → users.id)  ◄── Customer who ordered
├─ order_number (unique)
├─ total_amount (decimal)
├─ status (enum)
├─ shipping_* (address fields)
├─ phone
├─ notes
└─ timestamps

ORDER_ITEMS Table
├─ id (PK)
├─ order_id (FK → orders.id)
├─ product_id (FK → products.id)
├─ quantity
├─ price (at time of order)
├─ subtotal (calculated)
└─ timestamps

CART Table
├─ id (PK)
├─ user_id (FK → users.id)
├─ product_id (FK → products.id)
├─ quantity
└─ timestamps

CATEGORIES Table
├─ id (PK)
├─ name
├─ description
├─ slug (unique)
└─ timestamps
```

---

## 🎯 Key Implementation Points

### 1. Auto-assign Customer on Registration
```php
// RegisterController.php
$customerRole = Role::where('name', 'Customer')->first();
$user->role_id = $customerRole->id;  // ← Automatic assignment
```

### 2. Admin Creates Employee
```php
// AdminController.php (Protected by middleware)
$employeeRole = Role::where('name', 'Employee')->first();
$user->role_id = $employeeRole->id;  // ← Admin assigns
```

### 3. Role Checking
```php
// In controllers/views
if ($user->isAdmin()) { /* ... */ }
if ($user->isCustomer()) { /* ... */ }
if ($user->isEmployee()) { /* ... */ }
```

### 4. Middleware Protection
```php
// In routes
Route::middleware(['auth', 'role:Admin'])->group(/* ... */);
```

---

## ✅ All Requirements Met

1. ✅ **Three roles created**: Admin, Customer, Employee
2. ✅ **Auto-assign Customer**: On registration
3. ✅ **Admin adds employees**: Via admin panel
4. ✅ **Complete database**: All e-commerce tables
5. ✅ **Relationships**: Properly defined
6. ✅ **Security**: Middleware protection
7. ✅ **Tested**: Sample data seeded

**System is fully operational!** 🚀
