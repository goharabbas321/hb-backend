<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'read_profile',
                'type' => 'Profile',
            ],
            [
                'name' => 'update_profile',
                'type' => 'Profile',
            ],
            [
                'name' => 'update_password',
                'type' => 'Profile',
            ],
            [
                'name' => 'enable_2fa',
                'type' => 'Profile',
            ],
            [
                'name' => 'disable_2fa',
                'type' => 'Profile',
            ],
            [
                'name' => 'logout_sessions',
                'type' => 'Profile',
            ],
            [
                'name' => 'create_api',
                'type' => 'API Control',
            ],
            [
                'name' => 'read_api',
                'type' => 'API Control',
            ],
            [
                'name' => 'update_api',
                'type' => 'API Control',
            ],
            [
                'name' => 'delete_api',
                'type' => 'API Control',
            ],
            [
                'name' => 'create_users',
                'type' => 'User Management',
            ],
            [
                'name' => 'read_users',
                'type' => 'User Management',
            ],
            [
                'name' => 'update_users',
                'type' => 'User Management',
            ],
            [
                'name' => 'delete_users',
                'type' => 'User Management',
            ],
            [
                'name' => 'restore_users',
                'type' => 'User Management',
            ],
            [
                'name' => 'statics_users',
                'type' => 'User Management',
            ],
            [
                'name' => 'create_roles',
                'type' => 'Roles',
            ],
            [
                'name' => 'read_roles',
                'type' => 'Roles',
            ],
            [
                'name' => 'update_roles',
                'type' => 'Roles',
            ],
            [
                'name' => 'delete_roles',
                'type' => 'Roles',
            ],
            [
                'name' => 'create_permissions',
                'type' => 'Permissions',
            ],
            [
                'name' => 'read_permissions',
                'type' => 'Permissions',
            ],
            [
                'name' => 'update_permissions',
                'type' => 'Permissions',
            ],
            [
                'name' => 'delete_permissions',
                'type' => 'Permissions',
            ],
            [
                'name' => 'read_settings',
                'type' => 'Settings',
            ],
            [
                'name' => 'update_settings',
                'type' => 'Settings',
            ],
            [
                'name' => 'read_logs',
                'type' => 'Settings',
            ],
            [
                'name' => 'manage_modules',
                'type' => 'Settings',
            ],
            [
                'name' => 'create_backups',
                'type' => 'Settings',
            ],
            [
                'name' => 'create_hospitals',
                'type' => 'Hospital Management',
            ],
            [
                'name' => 'read_hospitals',
                'type' => 'Hospital Management',
            ],
            [
                'name' => 'update_hospitals',
                'type' => 'Hospital Management',
            ],
            [
                'name' => 'delete_hospitals',
                'type' => 'Hospital Management',
            ],
            [
                'name' => 'restore_hospitals',
                'type' => 'Hospital Management',
            ],
            [
                'name' => 'statics_hospitals',
                'type' => 'Hospital Management',
            ],
            [
                'name' => 'create_appointments',
                'type' => 'Appointments',
            ],
            [
                'name' => 'read_appointments',
                'type' => 'Appointments',
            ],
            [
                'name' => 'update_appointments',
                'type' => 'Appointments',
            ],
            [
                'name' => 'delete_appointments',
                'type' => 'Appointments',
            ],
            [
                'name' => 'restore_appointments',
                'type' => 'Appointments',
            ],
            [
                'name' => 'statics_appointments',
                'type' => 'Appointments',
            ],
            [
                'name' => 'create_doctors',
                'type' => 'Doctors',
            ],
            [
                'name' => 'read_doctors',
                'type' => 'Doctors',
            ],
            [
                'name' => 'update_doctors',
                'type' => 'Doctors',
            ],
            [
                'name' => 'delete_doctors',
                'type' => 'Doctors',
            ],
            [
                'name' => 'restore_doctors',
                'type' => 'Doctors',
            ],
            [
                'name' => 'statics_doctors',
                'type' => 'Doctors',
            ],
            [
                'name' => 'create_specializations',
                'type' => 'Specializations',
            ],
            [
                'name' => 'read_specializations',
                'type' => 'Specializations',
            ],
            [
                'name' => 'update_specializations',
                'type' => 'Specializations',
            ],
            [
                'name' => 'delete_specializations',
                'type' => 'Specializations',
            ],
            [
                'name' => 'restore_specializations',
                'type' => 'Specializations',
            ],
            [
                'name' => 'statics_specializations',
                'type' => 'Specializations',
            ],
            [
                'name' => 'create_facilities',
                'type' => 'Specializations',
            ],
            [
                'name' => 'read_facilities',
                'type' => 'Specializations',
            ],
            [
                'name' => 'update_facilities',
                'type' => 'Specializations',
            ],
            [
                'name' => 'delete_facilities',
                'type' => 'Specializations',
            ],
            [
                'name' => 'restore_facilities',
                'type' => 'Specializations',
            ],
            [
                'name' => 'statics_facilities',
                'type' => 'Specializations',
            ],
            [
                'name' => 'create_cities',
                'type' => 'Cities',
            ],
            [
                'name' => 'read_cities',
                'type' => 'Cities',
            ],
            [
                'name' => 'update_cities',
                'type' => 'Cities',
            ],
            [
                'name' => 'delete_cities',
                'type' => 'Cities',
            ],
            [
                'name' => 'restore_cities',
                'type' => 'Cities',
            ],
            [
                'name' => 'statics_cities',
                'type' => 'Cities',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $roles = [
            [
                'name' => 'super_admin'
            ],
            [
                'name' => 'hospital'
            ],
            [
                'name' => 'patient'
            ]
        ];

        foreach ($roles as $role) {
            $role = Role::create($role);
        }

        /** @var Role $super_adminRole */
        $super_adminRole = Role::whereName('super_admin')->first();
        /** @var Role $adminRole */
        $adminRole = Role::whereName('hospital')->first();
        /** @var Role $patientRole */
        $patientRole = Role::whereName('patient')->first();

        $permissionSuperAdmin = [
            'read_profile',
            'update_profile',
            'update_password',
            'enable_2fa',
            'disable_2fa',
            'logout_sessions',
            'create_api',
            'read_api',
            'update_api',
            'delete_api',
            'create_users',
            'read_users',
            'update_users',
            'delete_users',
            'restore_users',
            'statics_users',
            'create_roles',
            'read_roles',
            'update_roles',
            'delete_roles',
            'create_permissions',
            'read_permissions',
            'update_permissions',
            'delete_permissions',
            'read_settings',
            'update_settings',
            'read_logs',
            'manage_modules',
            'create_backups',
            'create_hospitals',
            'read_hospitals',
            'update_hospitals',
            'delete_hospitals',
            'restore_hospitals',
            'statics_hospitals',
            'create_appointments',
            'read_appointments',
            'update_appointments',
            'delete_appointments',
            'restore_appointments',
            'statics_appointments',
            'create_doctors',
            'read_doctors',
            'update_doctors',
            'delete_doctors',
            'restore_doctors',
            'statics_doctors',
            'create_specializations',
            'read_specializations',
            'update_specializations',
            'delete_specializations',
            'restore_specializations',
            'statics_specializations',
            'create_facilities',
            'read_facilities',
            'update_facilities',
            'delete_facilities',
            'restore_facilities',
            'statics_facilities',
            'create_cities',
            'read_cities',
            'update_cities',
            'delete_cities',
            'restore_cities',
            'statics_cities',
        ];

        $super_adminPermission = Permission::whereIn(
            'name',
            $permissionSuperAdmin
        )->pluck('name', 'id');

        $permissionAdmin = [
            'read_profile',
            'update_profile',
            'update_password',
            'enable_2fa',
            'disable_2fa',
            'logout_sessions',
            'create_users',
            'read_users',
            'update_users',
            'read_hospitals',
            'update_hospitals',
            'create_appointments',
            'read_appointments',
            'update_appointments',
            'statics_appointments',
            'create_doctors',
            'read_doctors',
            'update_doctors',
            'statics_doctors',
            'create_specializations',
            'read_specializations',
            'update_specializations',
            'create_facilities',
            'read_facilities',
            'update_facilities',
            'create_cities',
            'read_cities',
            'update_cities',
        ];

        $adminPermission = Permission::whereIn(
            'name',
            $permissionAdmin
        )->pluck('name', 'id');

        $permissionPatient = [
            'read_profile',
            'update_profile',
            'update_password',
            'enable_2fa',
            'disable_2fa',
            'logout_sessions',
            'read_hospitals',
        ];

        $patientPermission = Permission::whereIn(
            'name',
            $permissionPatient
        )->pluck('name', 'id');

        $super_adminRole->givePermissionTo($super_adminPermission);
        $adminRole->givePermissionTo($adminPermission);
        $patientRole->givePermissionTo($patientPermission);
    }
}
