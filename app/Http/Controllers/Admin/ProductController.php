<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\DeletedProduct;
use App\Models\Warning;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $unvalidatedProducts = Product::where('validated', 0)->get();
        return view('admin.products.index', compact('unvalidatedProducts'));
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function validateProduct(Product $product)
    {
        $product->validated = 1;
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product has been validated.');
    }

    public function invalidateProduct(Product $product, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Store product information in deleted_products table
        $deletedProduct = DeletedProduct::create([
            'user_id' => $product->user_id,
            'name' => $product->name,
            'description' => $product->description,
            'product_type' => $product->product_type,
            'price' => $product->price,
            'price_per_day' => $product->price_per_day,
            'available_from' => $product->available_from,
            'available_to' => $product->available_to,
            'stock_quantity' => $product->stock_quantity,
            'image' => $product->image,
            'rental_available' => $product->rental_available,
        ]);

        // Create a warning associated with the deleted product
        Warning::create([
            'user_id' => $product->user_id,
            'deleted_product_id' => $deletedProduct->id,
            'reason' => $request->reason,
        ]);

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product has been unvalidated and user has been warned.');
    }
}
