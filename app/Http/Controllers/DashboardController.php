<?php

namespace App\Http\Controllers;

use App\Models\Banner; 
use App\Models\Servico;
use App\Models\User;        
use App\Models\Group;       
use App\Models\MenuSection; 
use App\Models\MenuItem;    


use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
                                     
            // Novos dados para os cards do menu lateral
            'totalUsuarios' => User::count(),
            'totalGrupos'   => class_exists(Group::class) ? Group::count() : 0,       
            'totalSecoes'   => class_exists(MenuSection::class) ? MenuSection::count() : 0, 
            'totalItens'    => class_exists(MenuItem::class) ? MenuItem::count() : 0,  
            
        ]);
    }
}
