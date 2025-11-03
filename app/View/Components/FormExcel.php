<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Nicho;


class FormExcel extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $nicho = Nicho::orderBy('updated_at', 'desc')->get();
        
        return view('components.form-excel', ['nichos' => $nicho]);
    }
}
