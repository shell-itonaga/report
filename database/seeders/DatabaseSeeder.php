<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 初期データを登録
        $this->call([
            UsersTableSeeder::class,
            WorkTypesTableSeeder::class,
            WorkClassesTableSeeder::class,
            WorkDetailsTableSeeder::class,
            CustomerTableSeeder::class,
        ]);
    }
}
