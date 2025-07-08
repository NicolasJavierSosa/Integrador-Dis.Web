<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            // Clave primaria
            $table->integer('codigo')->autoIncrement()->primary();

            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_limite_inscripcion');
            $table->integer('cupo');

            $table->json('horario')->nullable();
            $table->json('dias')->nullable();

            $table->string('modalidad');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
