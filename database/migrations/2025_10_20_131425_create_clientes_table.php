<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {


       Schema::create('nichos', function (Blueprint $table) {
    $table->id();
    $table->string('nicho')->nullable();
    $table->timestamps();
});
        
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nomedaempresa')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('nomedoresponsavel')->nullable();
            $table->string('estagio_de_contato')->nullable();
            $table->string('ultimo_contato_resultado')->nullable();
            $table->dateTime('ultimoContato')->nullable();
            $table->integer('quantidadeDeContato')->nullable();
            $table->text('observacao')->nullable();
            $table->foreignId('nicho_id')->nullable()->constrained('nichos')->nullOnDelete();
            $table->timestamps();
        });

        
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
