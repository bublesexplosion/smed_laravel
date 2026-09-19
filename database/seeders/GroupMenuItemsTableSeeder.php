<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupMenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('group_menu_items')->delete();
        
        \DB::table('group_menu_items')->insert(array (
        //---Grupos   
        1 => 
            array (
                'id' => 1,
                'group_id' => 1,
                'menu_item_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        //--- usuario
        2 => 
            array (
                'id' => 2,
                'group_id' => 1,
                'menu_item_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        //---items 
        3 => 
            array (
                'id' => 3,
                'group_id' => 1,
                'menu_item_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        //--- secao
        4 => 
            array (
                'id' => 4,
                'group_id' => 1,
                'menu_item_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        //--- tabela
        5 => 
            array (
                'id' => 5,
                'group_id' => 1,
                'menu_item_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),    
        //--- menuPrincipal
        6 => 
            array (
                'id' => 6,
                'group_id' => 1,
                'menu_item_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),    
        ));
    }
}