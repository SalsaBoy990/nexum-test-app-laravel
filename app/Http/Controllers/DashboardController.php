<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Support\InteractsWithBanner;
use Illuminate\Support\Facades\Session;


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

        if (!session()->exists('categories')) {

            // TODO: Find a better solution for fewer number of queries if possible
            $categories = Category::whereNull('category_id')
                ->with(['childrenCategories'])
                ->get();

            // The categories are stored in the session to have fewer queries
            // Only when creating, updating and deleting categories is the session deleted,
            // and the queries then re-run
            session(['categories' => $categories]);
        } else {
            $categories = Session::get('categories');
        }

        // If exists in session, then use it
        $documents = Session::get('documents');
        $selectedCategory = Session::get('selectedCategory');

        if (!$documents || !$selectedCategory) {
            // the default is the first category
            $selectedCategory = $categories->first();
            $documents = $selectedCategory->documents()->get();
        }

        return view('admin.dashboard')->with([
            'categories' => $categories,
            'documents' => $documents,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
