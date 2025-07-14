<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard' => [
            'view'
        ],
        'users' => [
            'view',
            'create',
            'edit',
            'delete'
        ],
        'kpimetrics'     => [
            'view',
            'create',
            'edit',
            'delete'
        ],
        'hitungkpi' => [
            'view',
        ],
        'kpirecords' => [
            'view',
            'edit',
            'update'
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $key => $value)
            foreach ($value as $permission) {
                // ketika menambahkan permission baru, yang lama tidak terhapus,akan tetapi hanya menambahkan yang baru
                Permission::firstOrCreate([
                    'name' => $key . '-' . $permission,
                    'guard_name' => 'web',
                ]);
            }
        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',

        ])->givePermissionTo(Permission::all());


        Role::firstOrCreate([
            'name' => 'karyawan'
        ])

            ->givePermissionTo([
                'dashboard-view',
                'users-view',
                'kpimetrics-view',
                'hitungkpi-view',
            ]);
            
        $user = User::first();
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
