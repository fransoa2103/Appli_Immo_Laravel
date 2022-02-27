<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    // method magic has_ManyRelationships ici ->hasAnnonces puisqu'on fait la relation entre les 
    // 2 tables Users et Annonces
    {
        User::factory(5)
        ->hasAnnonces(5)
        ->create();
    }
}
