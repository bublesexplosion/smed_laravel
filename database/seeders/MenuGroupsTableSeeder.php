<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_groups')->delete();
        
        \DB::table('menu_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'group_id' => 1,
                'menu_item_id' => 1,
                'created_at' => '2026-04-02 11:22:13',
                'updated_at' => '2026-04-02 11:22:13',
            ),
            1 => 
            array (
                'id' => 2,
                'group_id' => 1,
                'menu_item_id' => 2,
                'created_at' => '2026-04-02 12:20:23',
                'updated_at' => '2026-04-02 12:20:23',
            ),
            2 => 
            array (
                'id' => 3,
                'group_id' => 1,
                'menu_item_id' => 3,
                'created_at' => '2026-04-02 12:21:19',
                'updated_at' => '2026-04-02 12:21:19',
            ),
            3 => 
            array (
                'id' => 4,
                'group_id' => 1,
                'menu_item_id' => 4,
                'created_at' => '2026-04-02 12:21:58',
                'updated_at' => '2026-04-02 12:21:58',
            ),
            
        ));
        
        
        
    }
}