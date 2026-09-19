<?php

namespace App\Traits;

use Inertia\Inertia;

trait HasBreadcrumbs
{
    /**
     * Define os breadcrumbs para a view.
     * O 'Início' já é incluído automaticamente pelo componente Vue.
     */
    protected function setBreadcrumbs(array $crumbs)
    {
        Inertia::share('breadcrumbs', $crumbs);
    }
}
