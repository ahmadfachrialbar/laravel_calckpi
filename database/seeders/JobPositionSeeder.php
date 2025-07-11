<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $positions = ['GM/GM', 'Manager/IT', 'Kepala/Marketing', 'Staff/HRD', 'Supervisor/Marketing', 'Staff/Marketing', 'Supervisor/Accounting', 'Staff/Accounting'];

        foreach ($positions as $pos) {
            \App\Models\JobPosition::firstOrCreate(['name' => $pos]);
        }
    }
}
