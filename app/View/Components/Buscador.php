<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Buscador extends Component {

    public string $action;
    public string $method;
    public string $palabra;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $action, string $method, string $palabra) {
        $this->action = $action;
        $this->method = $method;
        $this->palabra = $palabra;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.buscador');
    }
}
