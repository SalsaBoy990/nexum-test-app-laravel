<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\InteractsWithBanner;


class DashboardController extends Controller
{
    use InteractsWithBanner;

    /**
     * Admin dashboard page
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('category_id')
            ->with(['categories', 'users'])
            ->get();
        $selectedCategory = $categories->first();
        $documents = $selectedCategory->documents()->get();

        return view('admin.dashboard')->with([
            'categories' => $categories,
            'documents' => $documents,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
