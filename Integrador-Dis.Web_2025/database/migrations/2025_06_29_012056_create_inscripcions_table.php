<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('inscripcions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('curso_codigo', 191);
        $table->foreign('curso_codigo')->references('codigo')->on('cursos')->onDelete('cascade');
        $table->timestamps();
    });
}

};
