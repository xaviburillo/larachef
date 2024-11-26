<?php

namespace App\View\Components;

use App\Models\Receta;
use Illuminate\View\Component;

class RecetaCard extends Component
{
    public Receta $receta;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Receta $receta)
    {
        $this->receta = $receta;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.receta-card');
    }
}
