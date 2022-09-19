<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory(1)->create([
            'name' => 'Gulácsi András',
            'email' => 'gulandras90@gmail.com',
            'password' => Hash::make('qnw_wkc4tfx1azp1XGW'),
         ]);

        $this->call(CategorySeeder::class);
        $this->call(DocumentSeeder::class);
    }
}
