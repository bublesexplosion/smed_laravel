<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'menu' => $request->user() ? $request->user()->getMenuData() : [],
            ],
            'menuData' => \App\Models\MenuPrincipal::whereNull('parent_id')
                ->with('subitems.subitems.subitems.subitems') // Suporta até 5 níveis de profundidade
                ->orderBy('ordem')
                ->get(),
        ]);
    }


    private function prepareMenuUrls($item)
{
    // Não altera absolutamente nada, envia o link puro do banco
    return $item;
}




}
