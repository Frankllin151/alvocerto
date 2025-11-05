<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Nicho;
use App\Models\EstagioContato;

class FiltroForm extends Component
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
        $estagioContato = EstagioContato::orderBy('updated_at', 'desc')->get();
        return view('components.filtro-form', ['nicho' => $nicho, 'estagioContato' => $estagioContato]);
    }
}
