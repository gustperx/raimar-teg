<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $principalOne = Category::create([
            'name' => 'Equipos informáticos'
        ]);

        $principalTwo = Category::create([
            'name' => 'Equipos medicos'
        ]);

        $computers = [
            'CPU',
            'Teclado',
            'Mouse',
            'Monitor',
            'Teléfono',
            'Fax',
            'Router',
            'Modem',
            'Switch',
            'Servidor',
            'Impresora',
            'Scanner',
            'Lectoras DVD',
            'UPS',
            'Laptops',
            'Video Beam',
            'Modem inalámbrico',
            'Radios',
        ];

        $medicals = [
            'RX Fijo',
            'RX Colimador',
            'RX Tubo',
            'RX Porta Chasis',
            'Procesadora Digital',
            'RX Telecomando',
            'Resonador',
            'Tomógrafo',
            'Inyector de Contraste',
            'Tensiometro Aneroide',
            'Nebulizador',
            'Monitor Multiparametro',
            'Desfibrilador/ Monitor',
            'Lámpara de Cuello (Cisne)',
            'Cama de Traslado',
            'ORL de Pared',
            'Tensiómetro de Mercurio',
            'Electrocardio',
            'Báscula Mecánica',
            'Tensiometro de Pared',
            'Infantometro',
            'Bomba de Infusión',
            'Cama Hospitalizacion',
            'Maquina de Anestesia',
            'Monitor de SPO2',
            'Unidad Electroquirúrgica',
            'Lampara Scialitica',
            'Cama Quirurgica',
            'Modelo de naCamara',
            'Insuflador de CO2',
            'Servocuna',
            'Incubadora Cerrada',
            'Torniquete',
            'Fuente de Luz (FrontoLuz)',
            'Telecámara',
            'Fuente de Luz',
            'Electrocauterio de Frecuencia',
            'Conductor de Instrumentos',
            'Torre Laparoscopia',
            'Sistema de Video Endoscopia',
            'Calentador',
            'Generador de Calor',
            'Limpiador Ultrasónico',
            'Autoclave',
            'Selladora',
            'Esterilizador a Gas',
            'Sierra Osciladora',
            'Ventilador Mecánico',
            'Cama de Unidad Intensivo',
            'Incubadora de Transporte',
            'Equipo de Fototerapia',
            'Monitor de Signos Vitales',
            'Ventilador de Terapia Neonatal',
            'Bascula Mecanica Neonatal',
            'Cama Ginecologia',
            'Manometro Regulador',
            'Flujometro de Oxigeno',
            'Saturometro Portátil',
            'ElectroCardiógrafo',
            'Rayos X Portatil',
            'Regulador de Oxigeno',
        ];

        foreach ($computers as $computer) {
            Category::create([
                'name' => $computer,
                'parent_id' => $principalOne->id
            ]);
        }

        foreach ($medicals as $medical) {
            Category::create([
                'name' => $medical,
                'parent_id' => $principalTwo->id
            ]);
        }
    }
}
