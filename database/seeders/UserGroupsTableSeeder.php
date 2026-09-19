<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_groups')->delete();
        
        \DB::table('user_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'group_id' => 1,
                'created_at' => '2026-04-02 12:16:37',
                'updated_at' => '2026-04-02 12:16:37',
            ),
            1 => 
            array (
                'id' => 7,
                'user_id' => 2,
                'group_id' => 5,
                'created_at' => '2026-04-22 11:51:31',
                'updated_at' => '2026-04-22 11:51:31',
            ),
            2 => 
            array (
                'id' => 8,
                'user_id' => 1,
                'group_id' => 5,
                'created_at' => '2026-05-05 16:08:42',
                'updated_at' => '2026-05-05 16:08:42',
            ),
        ));
        
        
    }
}