<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_items')->delete();
        
        \DB::table('menu_items')->insert(array (
           0 => 
            array (
                'id' => 1,
                'menu_section_id' => 1,
                'label' => 'Usuarios',
                'link' => 'admin.users.index',
                'icon' => 'fas fa-user',
                'order' => 1,
                'created_at' => '2026-04-02 14:22:13',
                'updated_at' => '2026-04-06 19:06:49',
            ),
            1 => 
            array (
                'id' => 2,
                'menu_section_id' => 1,
                'label' => 'Grupos',
                'link' => 'admin.groups.index',
                'icon' => 'fas fa-users-cog',
                'order' => 2,
                'created_at' => '2026-04-02 15:20:23',
                'updated_at' => '2026-04-06 19:07:06',
            ),
            2 => 
            array (
                'id' => 3,
                'menu_section_id' => 1,
                'label' => 'Itens',
                'link' => 'admin.menu-items.index',
                'icon' => 'fas fa-sitemap',
                'order' => 3,
                'created_at' => '2026-04-02 15:21:19',
                'updated_at' => '2026-04-06 19:07:32',
            ),
            3 => 
            array (
                'id' => 4,
                'menu_section_id' => 1,
                'label' => 'Seção',
                'link' => 'admin.menu-sections.index',
                'icon' => 'fas fa-wallet',
                'order' => 4,
                'created_at' => '2026-04-02 15:21:58',
                'updated_at' => '2026-04-06 19:07:21',
            ),
             4 => 
            array (
                'id' => 5,
                'menu_section_id' => 1,
                'label' => 'Tabelas',
                'link' => 'admin.tipos.index',
                'icon' => 'fas fa-table',
                'order' => 5,
                'created_at' => '2026-04-02 15:21:58',
                'updated_at' => '2026-04-06 19:07:21',
            ),
            5 => 
            array (
                'id' => 6,
                'menu_section_id' => 1,
                'label' => 'Menu Principal',
                'link' => 'admin.menuPrincipal.index',
                'icon' => 'fas fa-table',
                'order' => 6,
                'created_at' => '2026-04-02 15:21:58',
                'updated_at' => '2026-04-06 19:07:21',
            ),
        ));
        
    }
}