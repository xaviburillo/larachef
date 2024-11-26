<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StarRating extends Component
{
    public $rating;
    public $count;
    public $extended;
    public $tipo;

    /**
     * Create a new component instance.
     */
    public function __construct(?float $rating, ?int $count, bool $extended, ?string $tipo)
    {
        $this->rating = $rating;
        $this->count = $count;
        $this->extended = $extended;
        $this->tipo = $tipo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.star-rating');
    }
}
