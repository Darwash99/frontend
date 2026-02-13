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
        //Tabla Departamentos
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        //Tabla Municipios
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->string('nombre');
            $table->timestamps();
        });

        //Tabla Tipos Documentos
        Schema::create('tipos_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        //Tabla Genero
        Schema::create('genero', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        //Paciente
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')
                ->constrained('tipos_documento');//relacion con la tabla tipos_documento

            $table->string('numero_documento')->unique();

            $table->string('nombre1');
            $table->string('nombre2')->nullable();
            $table->string('apellido1');
            $table->string('apellido2')->nullable();

            $table->foreignId('genero_id')
                ->constrained('genero');

            $table->foreignId('departamento_id')
                ->constrained('departamentos');//relacion con la tabla departamentos

            $table->foreignId('municipio_id')
                ->constrained('municipios');//relacion con la tabla municipios

            $table->string('correo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
        Schema::dropIfExists('municipios');
        Schema::dropIfExists('departamentos');
        Schema::dropIfExists('tipos_documento');
        Schema::dropIfExists('genero');

    }
};
