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
        User::create([
            'name'=>'Administrador Nutrición',
            'email'=>'admin@123',
            'password'=>bcrypt('nutri2025')
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
        Bed::create(['area_id' => 1, 'codigo' => '1']);
        Bed::create(['area_id' => 1, 'codigo' => '2']);
        Bed::create(['area_id' => 1, 'codigo' => '3']);
        Bed::create(['area_id' => 1, 'codigo' => '4']);
        Bed::create(['area_id' => 1, 'codigo' => '5']);
        Bed::create(['area_id' => 1, 'codigo' => '6']);
        Bed::create(['area_id' => 1, 'codigo' => '7']);
        Bed::create(['area_id' => 1, 'codigo' => '8']);
        Bed::create(['area_id' => 1, 'codigo' => '9']);
        Bed::create(['area_id' => 1, 'codigo' => '10']);
        Bed::create(['area_id' => 1, 'codigo' => '11']);
        Bed::create(['area_id' => 1, 'codigo' => '12']);
        Bed::create(['area_id' => 1, 'codigo' => '13']);
        Bed::create(['area_id' => 1, 'codigo' => '14']);
        Bed::create(['area_id' => 1, 'codigo' => '15']);
        Bed::create(['area_id' => 1, 'codigo' => '16']);
        Bed::create(['area_id' => 1, 'codigo' => '17']);
        Bed::create(['area_id' => 1, 'codigo' => '18']);
        Bed::create(['area_id' => 1, 'codigo' => '19']);
        Bed::create(['area_id' => 1, 'codigo' => '20']);
        Bed::create(['area_id' => 1, 'codigo' => '21']);

        // Observación 1 (id = 2)
        Bed::create(['area_id' => 2, 'codigo' => '1']);
        Bed::create(['area_id' => 2, 'codigo' => '2']);
        Bed::create(['area_id' => 2, 'codigo' => '3']);
        Bed::create(['area_id' => 2, 'codigo' => '4']);
        Bed::create(['area_id' => 2, 'codigo' => '5']);
        Bed::create(['area_id' => 2, 'codigo' => '6']);
        Bed::create(['area_id' => 2, 'codigo' => '7']);
        Bed::create(['area_id' => 2, 'codigo' => '8']);
        Bed::create(['area_id' => 2, 'codigo' => '9']);
        Bed::create(['area_id' => 2, 'codigo' => '10']);
        Bed::create(['area_id' => 2, 'codigo' => '11']);
        Bed::create(['area_id' => 2, 'codigo' => '12']);
        Bed::create(['area_id' => 2, 'codigo' => '13']);
        Bed::create(['area_id' => 2, 'codigo' => '14']);
        Bed::create(['area_id' => 2, 'codigo' => '15']);

        // Observación 2 (id = 3)
        Bed::create(['area_id' => 3, 'codigo' => '1']);
        Bed::create(['area_id' => 3, 'codigo' => '2']);
        Bed::create(['area_id' => 3, 'codigo' => '3']);
        Bed::create(['area_id' => 3, 'codigo' => '4']);
        Bed::create(['area_id' => 3, 'codigo' => '5']);
        Bed::create(['area_id' => 3, 'codigo' => '6']);
        Bed::create(['area_id' => 3, 'codigo' => '7']);
        Bed::create(['area_id' => 3, 'codigo' => '8']);
        Bed::create(['area_id' => 3, 'codigo' => '9']);
        Bed::create(['area_id' => 3, 'codigo' => '10']);
        Bed::create(['area_id' => 3, 'codigo' => '11']);
        Bed::create(['area_id' => 3, 'codigo' => '12']);
        Bed::create(['area_id' => 3, 'codigo' => '13']);
        Bed::create(['area_id' => 3, 'codigo' => '14']);
        Bed::create(['area_id' => 3, 'codigo' => '15']);

        // UVI-2 (id = 4)
        Bed::create(['area_id' => 4, 'codigo' => '1']);
        Bed::create(['area_id' => 4, 'codigo' => '2']);
        Bed::create(['area_id' => 4, 'codigo' => '3']);
        Bed::create(['area_id' => 4, 'codigo' => '4']);

        // TraumaShock (id = 5)
        Bed::create(['area_id' => 5, 'codigo' => '1']);
        Bed::create(['area_id' => 5, 'codigo' => '2']);
        Bed::create(['area_id' => 5, 'codigo' => '3']);

        // Tópico (id = 6)
        Bed::create(['area_id' => 6, 'codigo' => '1']);
        Bed::create(['area_id' => 6, 'codigo' => '2']);
        Bed::create(['area_id' => 6, 'codigo' => '3']);
        Bed::create(['area_id' => 6, 'codigo' => '4']);
        Bed::create(['area_id' => 6, 'codigo' => '5']);
        Bed::create(['area_id' => 6, 'codigo' => '6']);
        Bed::create(['area_id' => 6, 'codigo' => '7']);
        Bed::create(['area_id' => 6, 'codigo' => '8']);
        Bed::create(['area_id' => 6, 'codigo' => '9']);
        Bed::create(['area_id' => 6, 'codigo' => '10']);
        Bed::create(['area_id' => 6, 'codigo' => '11']);
        Bed::create(['area_id' => 6, 'codigo' => '12']);
        Bed::create(['area_id' => 6, 'codigo' => '13']);
        Bed::create(['area_id' => 6, 'codigo' => '14']);
        Bed::create(['area_id' => 6, 'codigo' => '15']);

        // CIRUGIA (id = 7)
        Bed::create(['area_id' => 7, 'codigo' => '1']);
        Bed::create(['area_id' => 7, 'codigo' => '2']);
        Bed::create(['area_id' => 7, 'codigo' => '3']);
        Bed::create(['area_id' => 7, 'codigo' => '4']);
        Bed::create(['area_id' => 7, 'codigo' => '5']);
        Bed::create(['area_id' => 7, 'codigo' => '6']);
        Bed::create(['area_id' => 7, 'codigo' => '7']);
        Bed::create(['area_id' => 7, 'codigo' => '8']);
        Bed::create(['area_id' => 7, 'codigo' => '9']);
        Bed::create(['area_id' => 7, 'codigo' => '10']);
        Bed::create(['area_id' => 7, 'codigo' => '11']);
        Bed::create(['area_id' => 7, 'codigo' => '12']);
        Bed::create(['area_id' => 7, 'codigo' => '13']);
        Bed::create(['area_id' => 7, 'codigo' => '14']);
        Bed::create(['area_id' => 7, 'codigo' => '15']);
        Bed::create(['area_id' => 7, 'codigo' => '16']);
        Bed::create(['area_id' => 7, 'codigo' => '17']);
        Bed::create(['area_id' => 7, 'codigo' => '18']);
        Bed::create(['area_id' => 7, 'codigo' => '19']);

        // OBSTETRICIA (id = 8)
        Bed::create(['area_id' => 8, 'codigo' => '1']);
        Bed::create(['area_id' => 8, 'codigo' => '2']);
        Bed::create(['area_id' => 8, 'codigo' => '3']);
        Bed::create(['area_id' => 8, 'codigo' => '4']);
        Bed::create(['area_id' => 8, 'codigo' => '5']);
        Bed::create(['area_id' => 8, 'codigo' => '6']);
        Bed::create(['area_id' => 8, 'codigo' => '7']);
        Bed::create(['area_id' => 8, 'codigo' => '8']);
        Bed::create(['area_id' => 8, 'codigo' => '9']);
        Bed::create(['area_id' => 8, 'codigo' => '10']);
        Bed::create(['area_id' => 8, 'codigo' => '11']);
        Bed::create(['area_id' => 8, 'codigo' => '12']);

        // GINECOLOGIA (id = 9)
        Bed::create(['area_id' => 9, 'codigo' => '1']);
        Bed::create(['area_id' => 9, 'codigo' => '2']);
        Bed::create(['area_id' => 9, 'codigo' => '3']);
        Bed::create(['area_id' => 9, 'codigo' => '4']);

        // PEDIATRIA (id = 10)
        Bed::create(['area_id' => 10, 'codigo' => '1']);
        Bed::create(['area_id' => 10, 'codigo' => '2']);
        Bed::create(['area_id' => 10, 'codigo' => '3']);
        Bed::create(['area_id' => 10, 'codigo' => '4']);
        Bed::create(['area_id' => 10, 'codigo' => '5']);
        Bed::create(['area_id' => 10, 'codigo' => '6']);
        Bed::create(['area_id' => 10, 'codigo' => '7']);
        Bed::create(['area_id' => 10, 'codigo' => '8']);
        Bed::create(['area_id' => 10, 'codigo' => '9']);
        Bed::create(['area_id' => 10, 'codigo' => '10']);
        Bed::create(['area_id' => 10, 'codigo' => '11']);
        Bed::create(['area_id' => 10, 'codigo' => '12']);
        Bed::create(['area_id' => 10, 'codigo' => '13']);

        // CENTRO OBSTETRICO (id = 11)
        Bed::create(['area_id' => 11, 'codigo' => '1']);
        Bed::create(['area_id' => 11, 'codigo' => '2']);
        Bed::create(['area_id' => 11, 'codigo' => '3']);
        Bed::create(['area_id' => 11, 'codigo' => '4']);
        Bed::create(['area_id' => 11, 'codigo' => '5']);
        Bed::create(['area_id' => 11, 'codigo' => '6']);
        Bed::create(['area_id' => 11, 'codigo' => '7']);
        Bed::create(['area_id' => 11, 'codigo' => '8']);
        Bed::create(['area_id' => 11, 'codigo' => '9']);
        Bed::create(['area_id' => 11, 'codigo' => '10']);

        // UVI-1 (id = 12)
        Bed::create(['area_id' => 12, 'codigo' => '1']);
        Bed::create(['area_id' => 12, 'codigo' => '2']);
        Bed::create(['area_id' => 12, 'codigo' => '3']);
        Bed::create(['area_id' => 12, 'codigo' => '4']);

        //Paciente

        Patient::create([
            'nombre' => 'Andre Paolo', 
            'apellido' => 'Luque Alfaro',
            'fecha_nacimiento'=>'2002-03-14',
            'dni'=>'73450173',
            
        ]);

        /* 
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
            
        ]);*/


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
            'indicaciones' => 'debe reposar y tomar pastillas',
            'diagnostico' => 'puesto para el alta ',
            
        ]);


        
    }
}
