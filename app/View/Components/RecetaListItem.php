<?php

namespace App\View\Components;

use App\Models\Receta as RecetaModel;
use Illuminate\View\Component;

class RecetaListItem extends Component {

    public RecetaModel $receta;
    public $section;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(RecetaModel $receta, string $section = "") {
        $this->receta = $receta;
        $this->section = $section;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.receta-list-item');
    }
}
