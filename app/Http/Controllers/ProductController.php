<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();
        $orders = Order::where('user_id', $user->id)->get();

        return view('user.profile', compact('user', 'products', 'orders'));
    }

    public function manage()
    {
        $user = Auth::user();
        $products = $user->products()->get();
        return view('user.products.manage', compact('products'));
    }

    public function add()
    {
        $mainCategories = Category::whereNull('parent_id')->get();
        return view('user.products.add', compact('mainCategories'));
    }

    public function edit(Product $product)
    {
        $mainCategories = Category::whereNull('parent_id')->get();
        $productCategories = $product->categories->pluck('id')->toArray();

        $selectedMainCategory = $product->categories->where('parent_id', null)->first();
        $selectedSubCategory = $selectedMainCategory ? $product->categories->where('parent_id', $selectedMainCategory->id)->first() : null;
        $selectedSubSubCategory = $selectedSubCategory ? $product->categories->where('parent_id', $selectedSubCategory->id)->first() : null;
        $selectedGenderCategory = $product->categories->where('parent_id', 62)->first();
        $selectedSizeCategory = $product->categories->where('parent_id', 66)->first();

        return view('user.products.edit', compact('product', 'mainCategories', 'productCategories', 'selectedMainCategory', 'selectedSubCategory', 'selectedSubSubCategory', 'selectedGenderCategory', 'selectedSizeCategory'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'product_type' => ['required', Rule::in([1, 2])],
            'price' => 'nullable|numeric',
            'price_per_day' => 'nullable|numeric',
            'availability_from' => 'nullable|date|after_or_equal:today',
            'availability_to' => 'nullable|date|after_or_equal:availability_from',
            'stock_quantity' => 'required|integer|min:0',
            'rental_available' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'main_category' => 'required|exists:categories,id',
            'sub_category' => 'nullable|exists:categories,id',
            'sub_sub_category' => 'nullable|exists:categories,id',
            'gender_category' => 'nullable|exists:categories,id',
            'size_category' => 'nullable|exists:categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/images/' . $fileName;
            $file->move(public_path('uploads/images'), $fileName);
            $imagePath = $filePath;
        }

        $user = Auth::user();
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->product_type = $request->product_type;
        $product->price = $request->price;
        $product->price_per_day = $request->price_per_day;
        $product->available_from = $request->availability_from;
        $product->available_to = $request->availability_to;
        $product->rental_available = $request->product_type == 2 ? ($request->rental_available ?? 0) : null;
        $product->stock_quantity = $request->stock_quantity;
        $product->image = $imagePath;
        $product->user_id = $user->id;
        $product->save();

        $categories = array_filter([
            $request->main_category,
            $request->sub_category,
            $request->sub_sub_category,
            $request->gender_category,
            $request->size_category
        ]);

        $product->categories()->sync($categories);

        return redirect()->route('user.products.manage')->with('success', 'Product added successfully!');
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'main_category' => 'required|exists:categories,id',
            'sub_category' => 'nullable|exists:categories,id',
            'sub_sub_category' => 'nullable|exists:categories,id',
            'gender_category' => 'nullable|exists:categories,id',
            'size_category' => 'nullable|exists:categories,id',
            'product_type' => 'required|in:1,2',
            'price' => 'nullable|numeric',
            'price_per_day' => 'nullable|numeric',
            'availability_from' => 'nullable|date|after_or_equal:today',
            'availability_to' => 'nullable|date|after_or_equal:availability_from',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        // Handle the image upload if a new image is uploaded
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Ensure price and price_per_day are set correctly based on product type
        if ($request->product_type == 1) {
            $validatedData['price_per_day'] = null;
            $validatedData['rental_available'] = null;
        } else {
            $validatedData['price'] = null;
            $validatedData['rental_available'] = $request->rental_available ?? 0;
        }

        // Update the product with the validated data
        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'] ?? $product->image,
            'main_category' => $validatedData['main_category'],
            'sub_category' => $validatedData['sub_category'],
            'sub_sub_category' => $validatedData['sub_sub_category'],
            'gender_category' => $validatedData['gender_category'],
            'size_category' => $validatedData['size_category'],
            'product_type' => $validatedData['product_type'],
            'price' => $validatedData['price'],
            'price_per_day' => $validatedData['price_per_day'],
            'available_from' => $validatedData['availability_from'],
            'available_to' => $validatedData['availability_to'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'rental_available' => $validatedData['rental_available']
        ]);

        // Update categories
        $categories = array_filter([
            $request->main_category,
            $request->sub_category,
            $request->sub_sub_category,
            $request->gender_category,
            $request->size_category
        ]);

        $product->categories()->sync($categories);

        return redirect()->route('user.products.manage')->with('success', 'Product updated successfully');
    }
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('user.products.manage')->with('success', 'Product deleted successfully!');
    }
}
