<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
             0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@teste.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$0k9ym9GW66GWJiSLpuQjxe/qqdr4R4SrLhTJjAoS/k03sXBkbH.wm',
                'created_at' => NULL,
                'updated_at' => NULL,
                
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'luciano correa',
                'email' => 'luciano1marco@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$oN9iI5ZXBuiIGmtQF7xRweSbF/Hgr22.tbXQ3gxPSWb61ps0mq502',
                'created_at' => NULL,
                'updated_at' => '2026-04-14 13:54:47',
                
            ),
        ));
        
    }
}