<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Nicho;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        $nichos = Nicho::all();

        if ($nichos->isEmpty()) {
            $this->call(NichoSeeder::class);
            $nichos = Nicho::all();
        }

        $estagios = [
            'Cliente ativo',
            'Cliente',
            'Negociação',
            'Prospecção',
            'Lead',
        ];

        // Gerar 100 clientes para cada mês do ano inteiro
        for ($mes = 1; $mes <= 12; $mes++) {

            for ($i = 1; $i <= 100; $i++) {

                // Data aleatória dentro do mês
                $dataAleatoria = Carbon::create(date('Y'), $mes, rand(1, 28));

                Cliente::create([
                    'nomedaempresa' => 'Empresa ' . Str::upper(Str::random(5)) . " LTDA",
                    'email' => 'contato_' . $mes . '_' . $i . '@empresa.com',
                    'telefone' => '(' . rand(11, 99) . ') 9' . rand(1000, 9999) . '-' . rand(1000, 9999),
                    'nomedoresponsavel' => fake()->name(),
                    'estagio_de_contato' => $estagios[array_rand($estagios)],
                    'ultimo_contato_resultado' => fake()->sentence(3),
                    'ultimoContato' => $dataAleatoria,
                    'quantidadeDeContato' => rand(1, 10),
                    'observacao' => fake()->sentence(10),
                    'nicho_id' => $nichos->random()->id,
                ]);
            }
        }
    }
}
