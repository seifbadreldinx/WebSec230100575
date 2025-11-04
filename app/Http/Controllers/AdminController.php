<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::whereHas('role', function($q) {
                $q->where('name', 'Customer');
            })->count(),
            'total_employees' => User::whereHas('role', function($q) {
                $q->where('name', 'Employee');
            })->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display a listing of employees.
     */
    public function employees()
    {
        $employeeRole = Role::where('name', 'Employee')->first();
        $employees = User::where('role_id', $employeeRole->id)->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function createEmployee()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function storeEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the Employee role
        $employeeRole = Role::where('name', 'Employee')->first();

        // Create the employee
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $employeeRole ? $employeeRole->id : null,
        ]);

        return redirect()->route('admin.employees')
            ->with('success', 'Employee created successfully!');
    }

    /**
     * Show the form for editing an employee.
     */
    public function editEmployee(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function updateEmployee(Request $request, User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee->name = $request->name;
        $employee->email = $request->email;
        
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }
        
        $employee->save();

        return redirect()->route('admin.employees')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroyEmployee(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $employee->delete();

        return redirect()->route('admin.employees')
            ->with('success', 'Employee deleted successfully!');
    }

    /**
     * Display a listing of all users.
     */
    public function users()
    {
        $users = User::with('role')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display all roles and their permissions.
     */
    public function roles()
    {
        $roles = Role::withCount('users')->get();
        $roleUsers = [];
        
        foreach ($roles as $role) {
            $roleUsers[$role->name] = User::where('role_id', $role->id)
                ->select('id', 'name', 'email')
                ->get();
        }
        
        return view('admin.roles.index', compact('roles', 'roleUsers'));
    }

    /**
     * List all customers (same as Employee controller)
     */
    public function customers()
    {
        $customerRole = Role::where('name', 'Customer')->first();
        $customers = User::where('role_id', $customerRole->id)
            ->withCount('boughtProducts')
            ->paginate(15);
        
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show charge credit form
     */
    public function showChargeCredit(User $user)
    {
        if (!$user->isCustomer()) {
            return redirect()->route('admin.customers')
                ->with('error', 'Can only charge credit for customers.');
        }
        
        return view('admin.customers.charge-credit', compact('user'));
    }

    /**
     * Charge customer credit
     */
    public function chargeCredit(Request $request, User $user)
    {
        if (!$user->isCustomer()) {
            return redirect()->route('admin.customers')
                ->with('error', 'Can only charge credit for customers.');
        }
        
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:10000',
        ]);
        
        $amount = $request->input('amount');
        
        if ($amount <= 0) {
            return redirect()->back()
                ->with('error', 'Amount must be positive.')
                ->withInput();
        }
        
        $user->credit += $amount;
        $user->save();
        
        return redirect()->route('admin.customers')
            ->with('success', "Successfully added $$amount credit to {$user->name}'s account.");
    }

    /**
     * List all products for management
     */
    public function products()
    {
        $products = \App\Models\Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show create product form
     */
    public function createProduct()
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku',
            'is_active' => 'boolean',
        ]);
        
        \App\Models\Product::create($request->all());
        
        return redirect()->route('admin.products')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show edit product form
     */
    public function editProduct(\App\Models\Product $product)
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'is_active' => 'boolean',
        ]);
        
        $product->update($request->all());
        
        return redirect()->route('admin.products')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete product
     */
    public function deleteProduct(\App\Models\Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Update stock only
     */
    public function updateStock(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);
        
        $product->stock = $request->input('stock');
        $product->save();
        
        return redirect()->back()
            ->with('success', 'Stock updated successfully.');
    }
}
