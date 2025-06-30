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
            // Clave primaria (coincide con el modelo)
            $table->integer('codigo')->autoIncrement()->primary();
            
            // Campos regulares
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_limite_inscripcion');
            $table->integer('cupo');
            $table->decimal('costo_inscripcion', 8, 2);
            $table->decimal('costo_mensual', 8, 2);
            $table->time('horario');
            
            // Campos para las relaciones (pivot)
            $table->timestamps();
        });

        // Si necesitas los campos adicionales comentados en el modelo
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('modalidad')->nullable()->after('horario');
            $table->string('dia')->nullable()->after('modalidad');
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