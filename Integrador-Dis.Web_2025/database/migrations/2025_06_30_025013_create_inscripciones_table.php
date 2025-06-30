<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            
            // Relación con usuarios
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Relación con cursos (usando codigo como integer)
            $table->integer('curso_codigo');
            $table->foreign('curso_codigo')
                  ->references('codigo')
                  ->on('cursos')
                  ->onDelete('cascade');
            
            // Campos adicionales
            $table->timestamp('inscripcion_date')->useCurrent();
            $table->timestamps();
            
            // Índices para mejor performance
            $table->index(['user_id', 'curso_codigo']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscripciones');
    }
};