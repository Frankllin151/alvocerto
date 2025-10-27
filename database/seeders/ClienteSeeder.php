<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Nicho;
use Carbon\Carbon;

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

        $clientes = [
            [
                'nomedaempresa' => 'Tech Solutions LTDA',
                'email' => 'contato@techsolutions.com',
                'telefone' => '(11) 99999-1234',
                'nomedoresponsavel' => 'João Silva',
                'estagio_de_contato' => 'Prospecção',
                'ultimo_contato_resultado' => 'Aguardando resposta',
                'ultimoContato' => Carbon::now()->subDays(2),
                'quantidadeDeContato' => 3,
                'observacao' => 'Interessado em sistema de gestão ERP.',
                'nicho_id' => $nichos->where('nicho', 'Tecnologia')->first()->id ?? null,
            ],
            [
                'nomedaempresa' => 'Clínica Vida Plena',
                'email' => 'atendimento@vidaplena.com',
                'telefone' => '(21) 98888-4567',
                'nomedoresponsavel' => 'Maria Santos',
                'estagio_de_contato' => 'Negociação',
                'ultimo_contato_resultado' => 'Proposta enviada',
                'ultimoContato' => Carbon::now()->subDay(),
                'quantidadeDeContato' => 5,
                'observacao' => 'Precisa de um site institucional moderno.',
                'nicho_id' => $nichos->where('nicho', 'Saúde')->first()->id ?? null,
            ],
            [
                'nomedaempresa' => 'Escola Saber+',
                'email' => 'diretoria@sabermais.com.br',
                'telefone' => '(31) 97777-7890',
                'nomedoresponsavel' => 'Carlos Pereira',
                'estagio_de_contato' => 'Cliente ativo',
                'ultimo_contato_resultado' => 'Fechou contrato',
                'ultimoContato' => Carbon::now(),
                'quantidadeDeContato' => 8,
                'observacao' => 'Sistema personalizado de gestão escolar.',
                'nicho_id' => $nichos->where('nicho', 'Educação')->first()->id ?? null,
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
