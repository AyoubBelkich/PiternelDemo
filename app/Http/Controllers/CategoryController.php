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
        })->where(function ($query) {
            $query->where('product_type', 1)
                ->orWhere('rental_available', 1);
        })->get();

        return view('categories.baby', compact('products', 'subcategories'));
    }

    public function showMamaCategory()
    {
        $category = Category::where('name', 'Mama')->first();
        $subcategories = $category->children;
        $products = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->where(function ($query) {
            $query->where('product_type', 1)
                ->orWhere('rental_available', 1);
        })->get();

        return view('categories.mama', compact('products', 'subcategories'));
    }

    public function showKindCategory()
    {
        $category = Category::where('name', 'Kind')->first();
        $subcategories = $category->children;
        $products = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->where(function ($query) {
            $query->where('product_type', 1)
                ->orWhere('rental_available', 1);
        })->get();

        return view('categories.kind', compact('products', 'subcategories'));
    }
    public function filterBabyProducts(Request $request)
    {
        $category = Category::where('name', 'Baby')->first();
        $subcategories = $category->children;

        $query = Product::query();

        $subcategoryIds = $request->input('subcategories', []);
        $genderIds = Category::where('name', 'Geslacht')->first()->children->pluck('id')->toArray();
        $sizeIds = Category::where('name', 'Maat')->first()->children->pluck('id')->toArray();

        $selectedGenderIds = array_intersect($subcategoryIds, $genderIds);
        $selectedSizeIds = array_intersect($subcategoryIds, $sizeIds);

        if (!empty($subcategoryIds)) {
            $query->whereHas('categories', function ($query) use ($subcategoryIds) {
                $query->whereIn('categories.id', $subcategoryIds);
            });
        } else {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            });
        }

        // Ensure products match both selected genders and sizes if both are selected
        if (!empty($selectedGenderIds) && !empty($selectedSizeIds)) {
            $query->whereHas('categories', function ($query) use ($selectedGenderIds) {
                $query->whereIn('categories.id', $selectedGenderIds);
            })->whereHas('categories', function ($query) use ($selectedSizeIds) {
                $query->whereIn('categories.id', $selectedSizeIds);
            });
        } elseif (!empty($selectedGenderIds)) {
            // Filter by selected genders only
            $query->whereHas('categories', function ($query) use ($selectedGenderIds) {
                $query->whereIn('categories.id', $selectedGenderIds);
            });
        } elseif (!empty($selectedSizeIds)) {
            // Filter by selected sizes only
            $query->whereHas('categories', function ($query) use ($selectedSizeIds) {
                $query->whereIn('categories.id', $selectedSizeIds);
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
                $query->whereIn('categories.id', $subcategoryIds); // Specify the table name here
            });
        } else {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id); // Specify the table name here
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
                $query->whereIn('categories.id', $subcategoryIds); // Specify the table name here
            });
        } else {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id); // Specify the table name here
            });
        }

        $products = $query->get();

        return view('categories.kind', compact('products', 'subcategories'));
    }
}
