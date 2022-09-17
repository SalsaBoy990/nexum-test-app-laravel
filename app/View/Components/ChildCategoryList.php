<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ChildCategoryList extends Component
{

    public $childCategory;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($childCategory)
    {
        $this->childCategory = $childCategory;
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
