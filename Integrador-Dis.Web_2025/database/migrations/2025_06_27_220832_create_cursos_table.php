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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
