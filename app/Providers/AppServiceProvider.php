<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Event;
use App\Models\MenuSection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot()
{
    // Compatibilidade com MySQL 5.7 usando utf8mb4 e limite de índice de 1000 bytes.
    Schema::defaultStringLength(191);

    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
        $user = auth()->user();
        if (!$user) return;

        // Busca as seções com itens que o usuário tem acesso via seus grupos
        $sections = MenuSection::with(['menuItems' => function ($query) use ($user) {
            $query->whereHas('groups', function ($q) use ($user) {
                $q->whereIn('groups.id', $user->groups->pluck('id'));
            })->orderBy('order');
        }])->orderBy('order')->get();

        foreach ($sections as $section) {
            // Adiciona o cabeçalho da seção no AdminLTE
            $event->menu->add($section->name);

            foreach ($section->menuItems as $item) {
                $event->menu->add([
                    'text' => $item->label,
                    'url'  => $item->link,
                    'icon' => $item->icon,
                ]);
            }
        }
    });
}
}
