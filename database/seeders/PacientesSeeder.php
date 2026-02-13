<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {

            DB::table('pacientes')->insert([
                'tipo_documento_id' => rand(1, 3),
                'numero_documento'  => '10' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'nombre1'           => fake()->firstName(),
                'nombre2'           => rand(0, 1) ? fake()->firstName() : null,
                'apellido1'         => fake()->lastName(),
                'apellido2'         => rand(0, 1) ? fake()->lastName() : null,
                'genero_id'         => rand(1, 2),
                'departamento_id'   => rand(1, 3),
                'municipio_id'      => rand(1, 5),
                'correo'            => fake()->unique()->safeEmail(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
