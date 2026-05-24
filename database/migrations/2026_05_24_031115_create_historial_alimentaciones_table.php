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
        Schema::create('historial_alimentaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('consulta_id')->constrained('consultas')->onDelete('cascade');
            $table->string('tipo_comida');
            $table->string('frecuencia'); // Guardado como JSON o string delimitado
            $table->text('detalles')->nullable();
            $table->string('condicion');
            $table->text('recomendacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_alimentaciones');
    }
};
