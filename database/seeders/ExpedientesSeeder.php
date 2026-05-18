<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Veterinario;
use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use Illuminate\Support\Carbon;

class ExpedientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Obtener o crear el perfil de Veterinario para el usuario existente
        $userVeterinario = User::where('rol', 'veterinario')->first();
        
        if (!$userVeterinario) {
            $this->command->error('No hay usuario veterinario en la base de datos para enlazar la consulta.');
            return;
        }

        $veterinario = Veterinario::firstOrCreate(
            ['usuario_id' => $userVeterinario->id],
            [
                'nombre_completo' => 'Dr. Juan Pérez',
                'especialidad' => 'Medicina General',
                'cedula_profesional' => '12345678',
                'foto_firma' => 'firma_default.png',
            ]
        );

        // 2. Crear un Dueño
        $dueno = Dueno::create([
            'nombre_completo' => 'María García',
            'telefono' => '555-123-4567',
            'direccion' => 'Calle Falsa 123, Ciudad',
        ]);

        // 3. Crear una Mascota vinculada al dueño
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Firulais',
            'especie' => 'Perro',
            'raza' => 'Mestizo',
            'fecha_nacimiento' => Carbon::now()->subYears(3)->format('Y-m-d'),
            'tipo_sangre' => 'DEA 1.1',
            'comportamiento' => 'Tranquilo',
            'es_adoptado' => true,
        ]);

        // 4. Crear dos Consultas vinculadas a la mascota y al veterinario
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subDays(15),
            'peso' => 12.5,
            'talla' => 45.0,
            'diagnostico' => 'Revisión general de rutina. Presenta ligero sarro dental.',
            'tratamiento' => 'Limpieza dental recomendada en los próximos meses. Mantener dieta actual.',
        ]);

        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now(),
            'peso' => 12.8,
            'talla' => 45.0,
            'diagnostico' => 'Acude a profilaxis dental programada. Sin complicaciones durante el procedimiento.',
            'tratamiento' => 'Se realiza limpieza dental exitosa. Reposo por 24 hrs y administrar antibiótico preventivo por 3 días.',
        ]);
        
        $this->command->info('ExpedientesSeeder: Dueño, Mascota y 2 Consultas creadas correctamente.');
    }
}
