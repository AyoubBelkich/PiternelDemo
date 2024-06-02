<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch sell products
        $sellProducts = Product::where('product_type', 1)->get();

        // Fetch rent products with rental availability set to YES
        $rentProducts = Product::where('product_type', 2)
            ->where('rental_available', true)
            ->get();

        return view('pages.home', compact('sellProducts', 'rentProducts'));
    }
}
