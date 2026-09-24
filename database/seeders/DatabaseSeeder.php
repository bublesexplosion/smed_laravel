<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

      //---necessario para que apareca o menu de admin
       $this->call(UsersTableSeeder::class);
       $this->call(GroupsTableSeeder::class);
       $this->call(MenuItemsTableSeeder::class);
       $this->call(MenuSectionsTableSeeder::class);
       $this->call(UserGroupsTableSeeder::class);
       $this->call(MenuGroupsTableSeeder::class);
       $this->call(GroupMenuItemsTableSeeder::class);
      $this->call(NoticiaSeeder::class);
      $this->call(MenuPrincipalSeeder::class);


    }
}
