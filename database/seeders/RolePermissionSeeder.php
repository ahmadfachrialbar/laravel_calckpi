<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard' => ['view'],
        'users' => ['view', 'create', 'edit', 'delete'],
        'kpimetrics' => ['view', 'create', 'edit', 'delete'],
        'hitungkpi' => ['view'],
        'kpirecord' => ['view', 'edit', 'update'],
    ];

    public function run(): void
    {
        foreach ($this->permissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::firstOrCreate([
                    'name' => $key . '-' . $permission,
                    'guard_name' => 'web',
                ]);
            }
        }

        // Role Admin = semua permission
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])
            ->givePermissionTo(Permission::all());

        // Role Karyawan = beberapa permission
        Role::firstOrCreate(['name' => 'karyawan', 'guard_name' => 'web'])
            ->givePermissionTo([
                'dashboard-view',
                'kpimetrics-view',
                'hitungkpi-view',
            ]);

        // Role Direksi = hanya dashboard dan resume
        Role::firstOrCreate(['name' => 'direksi', 'guard_name' => 'web'])
            ->givePermissionTo([
                'dashboard-view',
                'kpirecord-view', // kalau direksi hanya melihat resume KPI
            ]);

        // Jadikan user pertama sebagai admin
        $user = User::first();
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
