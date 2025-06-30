<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ModalidadEnum;
use App\Enums\DiaSemanaEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description');
            $table->string('category');
            $table->string('owner');
            $table->date('begin_date');
            $table->date('end_date');
            $table->date('insc_date_limit');
            $table->integer('quota');
            $table->enum('mode', ModalidadEnum::values());
            $table->double('insc_cost');
            $table->double('month_cost');
            $table->json('schedule');
            $table->json('days', DiaSemanaEnum::values());

            $table->timestamps();
        });
    }
{
    Schema::create('cursos', function (Blueprint $table) {
        $table->integer('codigo')->autoIncrement()->primary(); // Entero auto-incremental
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->date('fecha_limite_inscripcion');
        $table->integer('cupo');
        $table->decimal('costo_inscripcion', 8, 2);
        $table->decimal('costo_mensual', 8, 2);
        $table->time('horario');
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
