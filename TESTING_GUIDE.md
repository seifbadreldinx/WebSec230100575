# 🧪 Testing Guide

## 📋 Prerequisites

Before testing, ensure your database is set up:

```bash
# Run migrations and seed test data
php artisan migrate:fresh --seed
```

## 👥 Test User Credentials

The system comes with pre-seeded test users:

### Admin User
- **Email**: `admin@example.com`
- **Password**: `password`
- **Role**: Admin
- **Credit**: $0.00

### Employee User
- **Email**: `employee@example.com`
- **Password**: `password`
- **Role**: Employee
- **Credit**: $0.00

### Customer User
- **Email**: `customer@example.com`
- **Password**: `password`
- **Role**: Customer
- **Credit**: $1,000.00

---

## ✅ Testing Checklist

### 1. Registration & Customer Role Assignment

**Test**: Register a new customer
1. Go to `/register`
2. Fill in name, email, password
3. Submit registration
4. ✅ **Expected**: Automatically assigned "Customer" role
5. ✅ **Expected**: Redirected to products page
6. ✅ **Expected**: Starting credit of $500.00

---

### 2. Admin - Add Employee

**Test**: Admin can create employees internally
1. Login as `admin@example.com` / `password`
2. Go to `/admin/dashboard`
3. Click "Employees" or go to `/admin/employees`
4. Click "Add Employee" or go to `/admin/employees/create`
5. Fill in name, email, password
6. Submit form
7. ✅ **Expected**: Employee created with "Employee" role
8. ✅ **Expected**: Employee appears in employees list
9. ✅ **Expected**: Employee can login and access employee dashboard

---

### 3. Customer - Buy Products

**Test**: Customer can purchase products
1. Login as `customer@example.com` / `password`
2. Go to `/products`
3. Browse products
4. Click "Buy Now" on a product
5. ✅ **Expected**: Product purchased successfully
6. ✅ **Expected**: Credit deducted from account
7. ✅ **Expected**: Product stock reduced by 1
8. ✅ **Expected**: Product appears in "My Purchases" (`/my-purchases`)

---

### 4. Insufficient Credit Page

**Test**: Show insufficient credit when credit is too low
1. Login as `customer@example.com` / `password`
2. Note current credit (should be $1,000.00)
3. Buy expensive products until credit is low
4. Try to buy a product that costs more than available credit
5. ✅ **Expected**: Redirected to insufficient credit page
6. ✅ **Expected**: Shows current credit, required amount, and shortage

**Alternative Test**: Create a new customer with low credit
1. Register a new customer (gets $500.00)
2. Try to buy a product worth $600.00
3. ✅ **Expected**: Insufficient credit page shown

---

### 5. Employee - Charge Customer Credit

**Test**: Employee can charge customer credit (positive values only)
1. Login as `employee@example.com` / `password`
2. Go to `/employee/dashboard`
3. Click "Customers" or go to `/employee/customers`
4. View customer list (only Customer role users)
5. Click "Charge Credit" on a customer
6. Enter amount (e.g., 100.00)
7. Submit form
8. ✅ **Expected**: Customer credit increased
9. ✅ **Expected**: Success message displayed
10. ✅ **Test negative values**: Try entering -10.00
    - ✅ **Expected**: Validation error (must be positive)
11. ✅ **Test zero**: Try entering 0
    - ✅ **Expected**: Validation error (must be > 0.01)

---

### 6. Employee - List Customers Only

**Test**: Employee can only see Customer role users
1. Login as `employee@example.com` / `password`
2. Go to `/employee/customers`
3. ✅ **Expected**: Only Customer role users in list
4. ✅ **Expected**: No Admin or Employee users visible
5. ✅ **Expected**: Shows customer name, email, current credit

---

### 7. Employee - Product Management (CRUD)

#### 7.1 Create Product
1. Login as `employee@example.com` / `password`
2. Go to `/employee/products`
3. Click "Add New Product" or go to `/employee/products/create`
4. Fill in product details:
   - Name: "Test Product"
   - Description: "This is a test product"
   - Price: 99.99
   - Stock: 10
   - Category: (select one)
   - SKU: (optional)
   - Active: (checked)
5. Submit form
6. ✅ **Expected**: Product created successfully
7. ✅ **Expected**: Product appears in products list

#### 7.2 Edit Product
1. Go to `/employee/products`
2. Click "Edit" on any product
3. Modify product details
4. Submit form
5. ✅ **Expected**: Product updated successfully
6. ✅ **Expected**: Changes reflected in product list

#### 7.3 Delete Product
1. Go to `/employee/products`
2. Click "Delete" on a product
3. Confirm deletion
4. ✅ **Expected**: Product deleted successfully
5. ✅ **Expected**: Product removed from list

---

### 8. Employee - Set Product Stock

**Test**: Employee can update product stock quantity
1. Login as `employee@example.com` / `password`
2. Go to `/employee/products`
3. Find a product in the list
4. In the "Stock" column, update the number in the input field
5. Click "Update" button
6. ✅ **Expected**: Stock updated successfully
7. ✅ **Expected**: New stock value reflected in table

**Alternative**: Use the edit form
1. Click "Edit" on a product
2. Change stock quantity
3. Save
4. ✅ **Expected**: Stock updated

---

### 9. Stock Reduction After Purchase

**Test**: Product stock decreases after customer purchase
1. Note initial stock of a product (e.g., 10 units)
2. Login as `customer@example.com` / `password`
3. Buy the product
4. Logout and login as `employee@example.com` / `password`
5. Go to `/employee/products`
6. Check the product stock
7. ✅ **Expected**: Stock reduced by 1 (now 9 units)
8. ✅ **Expected**: Stock continues to decrease with each purchase

---

### 10. Permission Checks

#### 10.1 Backend Permission Checks
**Test**: Unauthorized access blocked
1. Login as `customer@example.com` / `password`
2. Try to access `/employee/dashboard`
3. ✅ **Expected**: 403 Forbidden or redirect
4. Try to access `/admin/dashboard`
5. ✅ **Expected**: 403 Forbidden or redirect

**Test**: Employee cannot access admin routes
1. Login as `employee@example.com` / `password`
2. Try to access `/admin/employees`
3. ✅ **Expected**: 403 Forbidden or redirect

#### 10.2 Frontend Permission Checks
**Test**: UI elements only show for authorized roles
1. Login as `customer@example.com` / `password`
2. Go to `/products`
3. ✅ **Expected**: "Buy Now" buttons visible
4. ✅ **Expected**: "My Purchases" link visible
5. ✅ **Expected**: No "Employee Dashboard" link visible
6. ✅ **Expected**: No "Admin Dashboard" link visible

1. Login as `employee@example.com` / `password`
2. Go to `/products`
3. ✅ **Expected**: "Employee Dashboard" link visible
4. ✅ **Expected**: No "Buy Now" buttons visible
5. ✅ **Expected**: No "My Purchases" link visible

---

## 🎯 Quick Test Scenarios

### Scenario 1: Complete Purchase Flow
1. **Employee**: Create a product with stock = 5
2. **Customer**: Buy the product (stock → 4)
3. **Employee**: Check stock is 4
4. **Customer**: Buy 3 more (stock → 1)
5. **Customer**: Try to buy 5 more
6. **Expected**: Insufficient stock error

### Scenario 2: Credit Management Flow
1. **Customer**: Check current credit ($1,000.00)
2. **Customer**: Buy product worth $200.00 (credit → $800.00)
3. **Employee**: Charge customer $300.00 (credit → $1,100.00)
4. **Customer**: Verify credit is $1,100.00
5. **Customer**: Buy product worth $1,200.00
6. **Expected**: Insufficient credit page

### Scenario 3: Product Lifecycle
1. **Employee**: Create product "Test Item" with stock = 10
2. **Customer**: Buy 5 units (stock → 5)
3. **Employee**: Edit product, change stock to 20
4. **Employee**: Set stock to 0 (mark as out of stock)
5. **Customer**: Try to buy product
6. **Expected**: Out of stock message

---

## 🐛 Troubleshooting

### Issue: Can't login
- Check database is migrated: `php artisan migrate`
- Check seeders ran: `php artisan db:seed`
- Verify users exist: `php artisan tinker` → `User::all()`

### Issue: Routes not working
- Clear route cache: `php artisan route:clear`
- Clear config cache: `php artisan config:clear`

### Issue: Permission denied errors
- Check middleware is registered in `app/Http/Kernel.php`
- Verify user has correct role: `User::find(1)->role->name`

### Issue: Stock not updating
- Check database transaction is working
- Verify `ProductController@buy` uses `decrement('stock', $quantity)`

---

## 📊 Test Results Template

Use this to track your testing:

```
[ ] Registration assigns Customer role
[ ] Admin can create employees
[ ] Customer can buy products
[ ] Insufficient credit page shows
[ ] Products added to bought list
[ ] Employee can charge customer credit (positive only)
[ ] Employee lists customers only
[ ] Employee can create products
[ ] Employee can edit products
[ ] Employee can delete products
[ ] Employee can set stock
[ ] Stock reduces after purchase
[ ] Permission checks on backend
[ ] Permission checks on UI
```

---

## 🚀 Ready to Test!

Start your Laravel server:
```bash
php artisan serve
```

Then visit: `http://localhost:8000`

Happy Testing! 🎉

