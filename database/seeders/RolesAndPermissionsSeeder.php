<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إعادة تعيين الصلاحيات المخزنة مؤقتًا
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الصلاحيات
        $permissions = [
            'create-roles',
            'edit-roles',
            'delete-roles',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
            'view-reports',
            'manage-users',
            'manage-services',
            'manage-settings',
            'upload-media',
            'view-media',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // إنشاء الأدوار
        $superAdmin = Role::create(['name' => 'super-admin']);
        $user = Role::create(['name' => 'user']);

        // تعيين الصلاحيات
        $superAdmin->givePermissionTo(Permission::all());
        $user->givePermissionTo(['view-reports', 'view-media']);

        // تعيين دور Super Admin لمستخدم
        $admin = \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('super-admin');
    }
}
