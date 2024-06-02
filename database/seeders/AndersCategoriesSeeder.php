<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class AndersCategoriesSeeder extends Seeder
{
    public function run()
    {
        // Fetch all main categories
        $mainCategories = Category::whereNull('parent_id')->get();

        foreach ($mainCategories as $mainCategory) {
            // Create "Anders" sub-category for each main category
            $andersSubCategory = Category::firstOrCreate([
                'name' => 'Anders',
                'parent_id' => $mainCategory->id,
            ]);

            // Fetch all sub-categories under the main category
            $subCategories = Category::where('parent_id', $mainCategory->id)->get();

            foreach ($subCategories as $subCategory) {
                // Create "Anders" sub-sub-category for each sub-category
                Category::firstOrCreate([
                    'name' => 'Anders',
                    'parent_id' => $subCategory->id,
                ]);
            }
        }
    }
}
