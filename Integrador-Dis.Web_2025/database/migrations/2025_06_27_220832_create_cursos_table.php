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

            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_limite_inscripcion');
            $table->integer('cupo');
            $table->decimal('costo_inscripcion', 8, 2);
            $table->decimal('costo_mensual', 8, 2);

            // 👇 CAMBIO: horario y dias como JSON
            $table->json('horario');
            $table->json('dias');

            $table->string('modalidad');

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
