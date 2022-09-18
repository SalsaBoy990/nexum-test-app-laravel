<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Support\InteractsWithBanner;

class CategoryController extends Controller
{
    use InteractsWithBanner;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        $data['category_id'] = empty($data['category_id']) ? null : intval($data['category_id']);

        Category::create($data);

        session()->forget('categories');

        $this->banner('Új kategória sikeresen hozzáadva.');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $input = $request->all();
        $category->updateOrFail($input);

        session()->forget('categories');

        $this->banner('A kategóriát sikeresen módosítottad.');
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $oldName = htmlentities($category->name);
        $category->deleteOrFail();

        session()->forget('categories');
    
        $this->banner('"' . $oldName . '"' . ' sikeresen törölve!');
        return redirect()->route('dashboard');
    }


    public function getSelected(Category $category)
    {
        $documentsOfSelectedCategory = $category->documents()->get();

        return redirect()->route('dashboard')->with([
            'selectedCategory' => $category,
            'documents' => $documentsOfSelectedCategory,
        ]);
    }
}
