<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'nomedaempresa' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'nomedoresponsavel' => $this->faker->name(),
            'estagio_de_contato' => $this->faker->randomElement(['Prospect', 'Contato feito', 'Fechado']),
            'ultimo_contato_resultado' => $this->faker->sentence(),
            'ultimoContato' => $this->faker->dateTimeThisYear(),
            'quantidadeDeContato' => $this->faker->numberBetween(0, 10),
            'observacao' => $this->faker->paragraph(),
        ];
    }
}
