<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function getSubcategories(Request $request)
    {
        $parent_id = $request->input('parent_id');
        $subcategories = Category::where('parent_id', $parent_id)->get();
        return response()->json($subcategories);
    }
    public function showBabyCategory()
    {
        $category = Category::where('name', 'Baby')->first();
        $subcategories = $category->children;
        $products = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->get();

        return view('categories.baby', compact('products', 'subcategories'));
    }

    public function showMamaCategory()
    {
        $category = Category::where('name', 'Mama')->first();
        $subcategories = $category->children;
        $products = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->get();

        return view('categories.mama', compact('products', 'subcategories'));
    }

    public function showKindCategory()
    {
        $category = Category::where('name', 'Kind')->first();
        $subcategories = $category->children;
        $products = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->get();

        return view('categories.kind', compact('products', 'subcategories'));
    }

    public function filterBabyProducts(Request $request)
    {
        $category = Category::where('name', 'Baby')->first();
        $subcategories = $category->children;

        $query = Product::query();

        if ($request->has('subcategories') && !empty($request->input('subcategories'))) {
            $subcategoryIds = $request->input('subcategories');
            $query->whereHas('categories', function ($query) use ($subcategoryIds) {
                $query->whereIn('id', $subcategoryIds);
            });
        } else {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            });
        }

        $products = $query->get();

        return view('categories.baby', compact('products', 'subcategories'));
    }
    public function filterMamaProducts(Request $request)
    {
        $category = Category::where('name', 'Mama')->first();
        $subcategories = $category->children;

        $query = Product::query();

        if ($request->has('subcategories') && !empty($request->input('subcategories'))) {
            $subcategoryIds = $request->input('subcategories');
            $query->whereHas('categories', function ($query) use ($subcategoryIds) {
                $query->whereIn('id', $subcategoryIds);
            });
        } else {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            });
        }

        $products = $query->get();

        return view('categories.mama', compact('products', 'subcategories'));
    }

    public function filterKindProducts(Request $request)
    {
        $category = Category::where('name', 'Kind')->first();
        $subcategories = $category->children;

        $query = Product::query();

        if ($request->has('subcategories') && !empty($request->input('subcategories'))) {
            $subcategoryIds = $request->input('subcategories');
            $query->whereHas('categories', function ($query) use ($subcategoryIds) {
                $query->whereIn('id', $subcategoryIds);
            });
        } else {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            });
        }

        $products = $query->get();

        return view('categories.kind', compact('products', 'subcategories'));
    }
}
