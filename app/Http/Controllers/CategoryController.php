<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Support\InteractsWithBanner;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    use InteractsWithBanner;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request, Category $category)
    {
        if (!$category->id) {
            if (Gate::denies('authorize_upload_to_root')) {
                $this->banner('Nincs feltöltési jogod a kategóriák gyökerébe.', 'danger');
                return redirect()->route('dashboard');
            }
        }
        else if (Gate::denies('authorize_upload_to_category', $category)) {
            $this->banner('Nincs feltöltési jogod a kategóriához.', 'danger');
            return redirect()->route('dashboard');
        }

        $data = $request->all();
        $data['category_id'] = empty($data['category_id']) ? null : intval($data['category_id']);
        $data['user_id'] = auth()->user()->id;

        Category::create($data);

        // categories needs to be re-queried from the db
        session()->forget('categories');

        $this->banner('Új kategória sikeresen hozzáadva.');
        return redirect()->route('dashboard');
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
        if (!$category->id) {
            if (Gate::denies('authorize_upload_to_root')) {
                $this->banner('Nincs feltöltési jogod a kategóriák gyökerébe.', 'danger');
                return redirect()->route('dashboard');
            }
        }
        if (Gate::denies('authorize_upload_to_category', $category)) {
            $this->banner('Nincs feltöltési jogod a kategóriához.', 'danger');
            return redirect()->route('dashboard');
        }

        $input = $request->all();
        $category->updateOrFail($input);

        // categories needs to be re-queried from the db
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

        // need to re-query categories when deleting one
        session()->forget('categories');

        $this->banner('"' . $oldName . '"' . ' sikeresen törölve!');
        return redirect()->route('dashboard');
    }


    /**
     * @param Category $category
     * 
     * Get selected category with the documents belonging to it
     * 
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function getSelected(Category $category)
    {
        $documents = $category->documents()->get();

        return redirect()->route('dashboard')->with([
            'selectedCategory' => $category,
            'documents' => $documents,
        ]);
    }
}
