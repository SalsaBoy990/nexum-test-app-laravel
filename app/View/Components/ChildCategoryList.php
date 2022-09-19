<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ChildCategoryList extends Component
{

    public $childCategory;
    public $selectedCategory;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($childCategory, $selectedCategory)
    {
        $this->childCategory = $childCategory;
        $this->selectedCategory = $selectedCategory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.child-category-list');
    }
}
