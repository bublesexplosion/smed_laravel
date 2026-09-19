<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuSectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_sections')->delete();
        
        \DB::table('menu_sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrador',
                'order' => 1,
                'created_at' => '2026-04-02 14:21:06',
                'updated_at' => '2026-04-07 19:46:07',
            ),
           
        ));
    }
}