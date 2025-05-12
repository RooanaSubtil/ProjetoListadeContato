<?php

namespace Database\Seeders;

use App\Models\Contatos;
use Illuminate\Database\Seeder;

class ContatosSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Contatos::factory(20)->create();

    }
}
