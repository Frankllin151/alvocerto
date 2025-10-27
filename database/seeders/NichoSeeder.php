<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nicho;

class NichoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $nichos = [
            ['nicho' => 'Tecnologia'],
            ['nicho' => 'Saúde'],
            ['nicho' => 'Educação'],
            ['nicho' => 'Alimentação'],
            ['nicho' => 'Moda'],
        ];

        foreach ($nichos as $nicho) {
            Nicho::create($nicho);
        }
    }
}
