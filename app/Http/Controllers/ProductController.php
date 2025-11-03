<?php

namespace App\Http\Controllers;

use App\Models\BoughtProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of products.
     */
    public function index()
    {
        try {
            $products = Product::with('category')->paginate(12);
            return view('products.index', compact('products'));
        } catch (\Exception $e) {
            \Log::error('Products index error: ' . $e->getMessage());
            return response('Error loading products: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show a single product.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    /**
     * Buy a product (Customer only).
     */
    public function buy(Request $request, Product $product)
    {
        $user = auth()->user();

        // Only customers can buy
        if (!$user->isCustomer()) {
            return redirect()->back()->with('error', 'Only customers can purchase products.');
        }

        // Check if product is available
        if (!$product->is_active || $product->stock <= 0) {
            return redirect()->back()->with('error', 'Product is not available.');
        }

        $quantity = $request->input('quantity', 1);
        $totalPrice = $product->price * $quantity;

        // Check if user has enough credit
        if (!$user->hasEnoughCredit($totalPrice)) {
            return redirect()->route('products.insufficient-credit', [
                'product' => $product->id,
                'required' => $totalPrice,
                'current' => $user->credit,
            ]);
        }

        // Check if enough stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        // Process the purchase
        DB::transaction(function () use ($user, $product, $quantity, $totalPrice) {
            // Deduct credit
            $user->deductCredit($totalPrice);

            // Reduce stock
            $product->decrement('stock', $quantity);

            // Add to bought products
            BoughtProduct::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'price_paid' => $product->price,
                'quantity' => $quantity,
            ]);
        });

        return redirect()->route('products.my-purchases')
            ->with('success', 'Product purchased successfully!');
    }

    /**
     * Show insufficient credit page.
     */
    public function insufficientCredit(Request $request)
    {
        $productId = $request->query('product');
        $required = $request->query('required');
        $current = $request->query('current');

        $product = Product::findOrFail($productId);
        $shortage = $required - $current;

        return view('products.insufficient-credit', compact('product', 'required', 'current', 'shortage'));
    }

    /**
     * Show user's purchased products.
     */
    public function myPurchases()
    {
        $user = auth()->user();

        if (!$user->isCustomer()) {
            return redirect()->back()->with('error', 'Only customers can view purchases.');
        }

        $purchases = BoughtProduct::with('product.category')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('products.my-purchases', compact('purchases'));
    }
}
