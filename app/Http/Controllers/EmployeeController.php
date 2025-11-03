<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:Employee']);
    }

    /**
     * Display employee dashboard.
     */
    public function index()
    {
        $stats = [
            'total_customers' => User::whereHas('role', function($q) {
                $q->where('name', 'Customer');
            })->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'low_stock_products' => Product::where('stock', '<=', 10)->where('stock', '>', 0)->count(),
        ];

        return view('employee.dashboard', compact('stats'));
    }

    /**
     * Display a listing of customers (only Customer role).
     */
    public function customers()
    {
        $customerRole = Role::where('name', 'Customer')->first();
        $customers = User::where('role_id', $customerRole->id)
            ->orderBy('name')
            ->paginate(15);

        return view('employee.customers.index', compact('customers'));
    }

    /**
     * Show the form for charging customer credit.
     */
    public function showChargeCredit(User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->isCustomer()) {
            abort(404, 'User is not a customer.');
        }

        return view('employee.customers.charge-credit', compact('customer'));
    }

    /**
     * Charge customer credit (positive values only).
     */
    public function chargeCredit(Request $request, User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->isCustomer()) {
            abort(404, 'User is not a customer.');
        }

        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:0.01', 'regex:/^\d+(\.\d{1,2})?$/'],
        ], [
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be positive and greater than zero.',
            'amount.regex' => 'Amount must have at most 2 decimal places.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $amount = $request->input('amount');

        // Charge credit (add to customer's account)
        $customer->addCredit($amount);

        return redirect()->route('employee.customers')
            ->with('success', "Successfully charged $".number_format($amount, 2)." to {$customer->name}'s account.");
    }

    /**
     * Display a listing of products for management.
     */
    public function products()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('employee.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function createProduct()
    {
        $categories = Category::all();
        return view('employee.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['nullable', 'boolean'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:products,sku'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active'),
            'sku' => $request->sku,
        ]);

        return redirect()->route('employee.products')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('employee.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function updateProduct(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['nullable', 'boolean'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:products,sku,' . $product->id],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock ?? 0;
        $product->category_id = $request->category_id;
        $product->is_active = $request->has('is_active');
        $product->sku = $request->sku;
        $product->save();

        return redirect()->route('employee.products')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroyProduct(Product $product)
    {
        $productName = $product->name;
        $product->delete();

        return redirect()->route('employee.products')
            ->with('success', "Product '{$productName}' deleted successfully!");
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('employee.products')
            ->with('success', "Product stock updated to {$product->stock} units.");
    }
}

