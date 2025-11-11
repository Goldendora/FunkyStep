<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Catalogo extends Component
{
    public $products;

    public function __construct($products = [])
    {
        $this->products = $products;
    }

    public function render()
    {
        return view('components.catalogo');
    }
}
