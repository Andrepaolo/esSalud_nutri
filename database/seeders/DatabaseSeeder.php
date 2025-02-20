<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Bed;
use App\Models\DailyRecord;
use App\Models\Diet;
use App\Models\Patient;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::create([
            'name'=>'Andre Luque Alfaro',
            'email'=>'andre@gmail.com',
            //'profile'=>'https://i.pinimg.com/564x/94/e5/32/94e5325468d2859b075bfabb4dc83c4e.jpg',
            'password'=>bcrypt('12345678')
        ]);
        Area::create(['nombre' => 'Medicina', 'description' => '1133']);
        Area::create(['nombre' => 'Observación 1', 'description' => 'null']);
        Area::create(['nombre' => 'Observación 2', 'description' => '1044']);
        Area::create(['nombre' => 'UVI 2', 'description' => 'null']);
        Area::create(['nombre' => 'TraumaShock', 'description' => 'null']);
        Area::create(['nombre' => 'Tópico', 'description' => 'null']);
        Area::create(['nombre' => 'CIRUGIA', 'description' => 'null']);
        Area::create(['nombre' => 'OBSTETRICIA', 'description' => 'null']);
        Area::create(['nombre' => 'GINECOLOGIA', 'description' => 'null']);
        Area::create(['nombre' => 'PEDIATRIA', 'description' => 'null']);
        Area::create(['nombre' => 'CENTRO OBSTETRICO', 'description' => 'null']);
        Area::create(['nombre' => 'UVI-1', 'description' => 'null']);
        // Medicina (id = 1)
        Bed::create(['area_id' => 1, 'codigo' => '201-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '201-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '202-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '202-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '203-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '203-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '204-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '204-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '205-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '205-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '206-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '206-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '207-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '207-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '208-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '208-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '209-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '209-BM']);
        Bed::create(['area_id' => 1, 'codigo' => '210-AM']);
        Bed::create(['area_id' => 1, 'codigo' => '210-BM']);
        Bed::create(['area_id' => 1, 'codigo' => 'A1M']);

        // Observación 1 (id = 2)
        Bed::create(['area_id' => 2, 'codigo' => 'O1-1']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-2']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-3']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-4']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-5']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-6']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-7']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-8']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-9']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-10']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-11']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-12']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-13']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-14']);
        Bed::create(['area_id' => 2, 'codigo' => 'O1-15']);

        // Observación 2 (id = 3)
        Bed::create(['area_id' => 3, 'codigo' => 'O2-1']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-2']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-3']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-4']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-5']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-6']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-7']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-8P']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-9P']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-10P']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-11P']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-12P']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-13']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-14']);
        Bed::create(['area_id' => 3, 'codigo' => 'O2-15']);

        // UVI-2 (id = 4)
        Bed::create(['area_id' => 4, 'codigo' => 'U2-1']);
        Bed::create(['area_id' => 4, 'codigo' => 'U2-2']);
        Bed::create(['area_id' => 4, 'codigo' => 'U2-3']);
        Bed::create(['area_id' => 4, 'codigo' => 'U4-4']);

        // TraumaShock (id = 5)
        Bed::create(['area_id' => 5, 'codigo' => 'TS-1']);
        Bed::create(['area_id' => 5, 'codigo' => 'TS-2']);
        Bed::create(['area_id' => 5, 'codigo' => 'TS-3']);

        // Tópico (id = 6)
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-1']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-2']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-3']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-4']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-5']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-6']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-7']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-8']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-9']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOI-10']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOC-1']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOC-2']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOC-3']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOC-4']);
        Bed::create(['area_id' => 6, 'codigo' => 'TOC-5']);

        // CIRUGIA (id = 7)
        Bed::create(['area_id' => 7, 'codigo' => '211-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '211-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '212C']);
        Bed::create(['area_id' => 7, 'codigo' => '213-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '213-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '214-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '214-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '215-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '215-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '216-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '216-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '217-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '217-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '218-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '218-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '219-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '219-BC']);
        Bed::create(['area_id' => 7, 'codigo' => '220-AC']);
        Bed::create(['area_id' => 7, 'codigo' => '220-BC']);

        // OBSTETRICIA (id = 8)
        Bed::create(['area_id' => 8, 'codigo' => '1-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '2-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '3-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '4-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '5-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '6-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '7-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '8-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '9-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '10-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => '11-OBS']);
        Bed::create(['area_id' => 8, 'codigo' => 'G-12']);

        // GINECOLOGIA (id = 9)
        Bed::create(['area_id' => 9, 'codigo' => '225-AG']);
        Bed::create(['area_id' => 9, 'codigo' => '225-BG']);
        Bed::create(['area_id' => 9, 'codigo' => '232-AG']);
        Bed::create(['area_id' => 9, 'codigo' => '232-BG']);

        // PEDIATRIA (id = 10)
        Bed::create(['area_id' => 10, 'codigo' => '226-AP']);
        Bed::create(['area_id' => 10, 'codigo' => '226-BP']);
        Bed::create(['area_id' => 10, 'codigo' => '227-AP']);
        Bed::create(['area_id' => 10, 'codigo' => '227-BP']);
        Bed::create(['area_id' => 10, 'codigo' => '228-AP']);
        Bed::create(['area_id' => 10, 'codigo' => '228-BP']);
        Bed::create(['area_id' => 10, 'codigo' => '229-AP']);
        Bed::create(['area_id' => 10, 'codigo' => '229-BP']);
        Bed::create(['area_id' => 10, 'codigo' => '230-AP']);
        Bed::create(['area_id' => 10, 'codigo' => '230-BP']);
        Bed::create(['area_id' => 10, 'codigo' => '231-AP']);
        Bed::create(['area_id' => 10, 'codigo' => '231-BP']);
        Bed::create(['area_id' => 10, 'codigo' => 'A1P']);

        // CENTRO OBSTETRICO (id = 11)
        Bed::create(['area_id' => 11, 'codigo' => '1-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '2-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '3-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '4-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '5-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '6-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '7-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '8-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '9-CO']);
        Bed::create(['area_id' => 11, 'codigo' => '10-CO']);

        // UVI-1 (id = 12)
        Bed::create(['area_id' => 12, 'codigo' => 'U1-1']);
        Bed::create(['area_id' => 12, 'codigo' => 'U1-2']);
        Bed::create(['area_id' => 12, 'codigo' => 'U1-3']);
        Bed::create(['area_id' => 12, 'codigo' => 'U1-4']);

        //Paciente

        Patient::create([
            'nombre' => 'Andre Paolo', 
            'apellido' => 'Luque Alfaro',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'73450173',
            
        ]);
        Patient::create([
            'nombre' => 'Fioerito', 
            'apellido' => 'Luque Alfaro',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'79878334',
            
        ]);
        Patient::create([
            'nombre' => 'Dina', 
            'apellido' => 'Paucar Lino',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'79812331',
            
        ]);
        Patient::create([
            'nombre' => 'Julian Paolo', 
            'apellido' => 'william pacaz',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'83451231',
            
        ]);
        Patient::create([
            'nombre' => 'Vlad', 
            'apellido' => 'Kasa  Amigo',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'69878334',
            
        ]);
        Patient::create([
            'nombre' => 'Harisson', 
            'apellido' => 'anjo Turq',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'59878844',
            
        ]);
        Patient::create([
            'nombre' => 'joshep ', 
            'apellido' => 'Lipa Lazo',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'43450173',
            
        ]);
        Patient::create([
            'nombre' => 'Mota', 
            'apellido' => 'Rodriguez Mejo',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'29878334',
            
        ]);
        Patient::create([
            'nombre' => 'Caleb', 
            'apellido' => 'Curly Hair',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'19878844',
            
        ]);
        Patient::create([
            'nombre' => 'Issac', 
            'apellido' => 'Sulca Suarez',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'12345678',
            
        ]);


        //diet
        Diet::create([
            'name'=>'C'
        ]);
        Diet::create(['name' => 'BL']);
        Diet::create(['name' => 'BL ATR']);
        Diet::create(['name' => 'LIC']);
        Diet::create(['name' => 'F.P']);
        Diet::create(['name' => 'L.A']);
        Diet::create(['name' => 'L']);
        Diet::create(['name' => 'A.C']);
        
        Diet::create(['name' => 'HGL']);
        Diet::create(['name' => 'HCL']);
        Diet::create(['name' => 'HGR']);
        Diet::create(['name' => 'HPI']);
        Diet::create(['name' => 'HIPOPT']);
        Diet::create(['name' => 'HIPOALER']);
        Diet::create(['name' => 'HIPOCAL']);
        Diet::create(['name' => 'HIPERCAL']);
        Diet::create(['name' => 'RENAL']);
        
        Diet::create(['name' => 'TRITUR']);
        Diet::create(['name' => 'MOLID']);
        Diet::create(['name' => 'PURÉ']);
        Diet::create(['name' => 'S/GRUM']);
        
        Diet::create(['name' => 'S/FIBRA']);
        Diet::create(['name' => 'C/FIBRA']);
        Diet::create(['name' => 'S/LÁCTEO']);
        Diet::create(['name' => 'S/FLATUL']);
        Diet::create(['name' => 'RICA EN Fe']);
        Diet::create(['name' => 'S/VIT.K']);
        Diet::create(['name' => 'S/CÍTIRCO']);
        Diet::create(['name' => 'S/IRRITAN']);
        Diet::create(['name' => 'S/BOCIOG']);
        
        Diet::create(['name' => 'SONDA']);
        Diet::create(['name' => 'V.O']);
        Diet::create(['name' => 'M.P.L']);
        Diet::create(['name' => 'M.P.P']);
        Diet::create(['name' => 'M.CHO']);
        Diet::create(['name' => 'M.F']);
        Diet::create(['name' => 'M.G']);
        Diet::create(['name' => 'GLUT']);
        Diet::create(['name' => 'VIT.K']);
        
        Diet::create(['name' => '1000 KCAL/DÍA']);
        Diet::create(['name' => '1200 KCAL/DÍA']);
        Diet::create(['name' => '1500 KCAL/DÍA']);
        Diet::create(['name' => '1800 KCAL/DÍA']);
        Diet::create(['name' => '2000 KCAL/DÍA']);
        Diet::create(['name' => '2200 KCAL/DÍA']);
        Diet::create(['name' => '2500 KCAL/DÍA']);
        Diet::create(['name' => '2800 KCAL/DÍA']);
        
        //Daily Records
        DailyRecord::create([
            'bed_id' => 1, 
            'patient_id' => 1,
            'fecha_registro' => now(),
            'desayuno' => '2000 KCAL/DÍA',
            'am10' => '2000 KCAL/DÍA',
            'almuerzo' => '2000 KCAL/DÍA',
            'pm4' => '2000 KCAL/DÍA',
            'cena' => '2000 KCAL/DÍA',
            'indicaciones' => 'haga lo siguiente',
            'diagnostico' => 'todo bien ',
            
        ]);


        
    }
}
