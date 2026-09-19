<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//---use ---------------------------------
use App\Http\Controllers\DashboardController;

//---use de menu administrativo--------------------------
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\MenuSectionController;
use App\Http\Controllers\Admin\UserController;
//-----use de outros----------------------------------
use App\Http\Controllers\Admin\AuxiliarController;
use App\Http\Controllers\Admin\MenuPrincipalController;
use App\Http\Controllers\NoticiaController;

 //--- rota para as paginas publicas-puxando do adminlte------------------
      Route::get('/', function () {
          return Inertia::render('Welcome', [
              'canLogin' => Route::has('login'),
              'canRegister' => Route::has('register'),
              'laravelVersion' => Application::VERSION,
              'phpVersion' => PHP_VERSION,

               'menuData' => \App\Models\MenuPrincipal::whereNull('parent_id')
                      ->with('subitems.subitems') // Isso traz os 3 níveis
                      ->orderBy('ordem')
                      ->get(),


              ]);
            })->name('Welcome');

          Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
          Route::get('/noticias/{noticia:slug}', [NoticiaController::class, 'show'])->name('noticias.show');


//----fim de use-----------------------------------------
//Route::get('/', function () {
//    return redirect()->route('login');
//});


  // Agrupe tudo que precisa de autenticação aqui(admin)
  Route::middleware('auth')->group(function () {

    // A ROTA DO DASHBOARD DEVE SER ESTA (Chamando o Controller):
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ADICIONE ESTE BLOCO PARA O ADMIN:
        Route::prefix('admin')->name('admin.')->group(function () {
          //--rota do meu lateral
            Route::resource('groups', GroupController::class);
            Route::resource('menu-items', MenuItemController::class);
            Route::resource('menu-sections', MenuSectionController::class);
            Route::resource('users', UserController::class);
            Route::resource('/Menuprincipal', \App\Http\Controllers\Admin\MenuPrincipalController::class)
                ->parameters(['menuprincipal' => 'id'])
                ->names('menuPrincipal');

            // Rota principal do CRUD genérico de itens (O menu dinâmico vai apontar diretamente para cá)
            Route::get('/cadastros/{slug_tipo}', [AuxiliarController::class, 'gerenciarRegistros'])->name('tipos.gerenciar');
            Route::post('/cadastros/{slug_tipo}/itens', [AuxiliarController::class, 'storeRegistro'])->name('tipos.store-item');
            Route::put('/cadastros/{slug_tipo}/itens/{id}', [AuxiliarController::class, 'updateRegistro'])->name('tipos.update-item');
            Route::delete('/cadastros/{slug_tipo}/itens/{id}', [AuxiliarController::class, 'destroyRegistro'])->name('tipos.destroy-item');

            // bloco de TIPOS atualizado com suporte a Editar e Excluir as Tabelas Pai
            Route::get('/configuracoes/tipos', [AuxiliarController::class, 'indexTipos'])->name('tipos.index');
            Route::post('/configuracoes/tipos', [AuxiliarController::class, 'storeTipo'])->name('tipos.store');
            Route::put('/configuracoes/tipos/{id}', [AuxiliarController::class, 'updateTipo'])->name('tipos.update');
            Route::delete('/configuracoes/tipos/{id}', [AuxiliarController::class, 'destroyTipo'])->name('tipos.destroy');

            //--outras menus aqui ex comercial


       });

});

require __DIR__.'/auth.php';
