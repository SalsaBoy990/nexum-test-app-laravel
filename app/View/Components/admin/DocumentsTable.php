<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class DocumentsTable extends Component
{
    public $documents;
    public $selectedCategory;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($documents, $selectedCategory)
    {
        $this->documents = $documents;
        $this->selectedCategory = $selectedCategory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.documents-table');
    }
}
