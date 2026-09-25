<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions definitions
        $permissions = [
            // Master Data
            'view_districts', 'manage_districts',
            'view_villages', 'manage_villages',
            'view_work_units', 'manage_work_units',
            'view_users', 'manage_users',
            'view_service_types', 'manage_service_types',
            'view_client_categories', 'manage_client_categories',
            'view_complaint_categories', 'manage_complaint_categories',
            'view_referral_institutions', 'manage_referral_institutions',
            'view_dtsen_purposes', 'manage_dtsen_purposes',

            // Service Requests
            'view_service_requests', 'create_service_requests', 'process_service_requests',
            'verify_service_requests', 'approve_service_requests', 'sign_service_requests',
            'delete_service_requests',

            // Rehabilitation Cases & Clients
            'view_clients', 'manage_clients',
            'view_rehabilitation_cases', 'create_rehabilitation_cases', 'manage_rehabilitation_cases',

            // Social Complaints
            'view_complaints', 'process_complaints', 'disposition_complaints', 'manage_complaints',

            // Information Pages & FAQs
            'view_information_pages', 'manage_information_pages',

            // Reports & Dashboard
            'view_dashboard', 'view_reports', 'export_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 1. Super Admin (Administrator)
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // 2. Petugas Dinsos (Verifikator & Operator Teknis)
        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $petugas->syncPermissions([
            'view_districts', 'view_villages', 'view_work_units',
            'view_service_types', 'view_client_categories', 'view_complaint_categories',
            'view_referral_institutions', 'view_dtsen_purposes',
            'view_service_requests', 'process_service_requests', 'verify_service_requests',
            'view_clients', 'manage_clients',
            'view_rehabilitation_cases', 'create_rehabilitation_cases', 'manage_rehabilitation_cases',
            'view_complaints', 'process_complaints', 'disposition_complaints',
            'view_information_pages', 'manage_information_pages',
            'view_dashboard', 'view_reports', 'export_reports',
        ]);

        // 3. Pejabat Penandatangan (Kepala Dinas / Kabid)
        $pejabat = Role::firstOrCreate(['name' => 'pejabat', 'guard_name' => 'web']);
        $pejabat->syncPermissions([
            'view_service_requests', 'approve_service_requests', 'sign_service_requests',
            'view_rehabilitation_cases',
            'view_complaints', 'disposition_complaints',
            'view_dashboard', 'view_reports', 'export_reports',
        ]);

        // 4. Pimpinan (Bupati / Kadis / Monitoring Eksekutif)
        $pimpinan = Role::firstOrCreate(['name' => 'pimpinan', 'guard_name' => 'web']);
        $pimpinan->syncPermissions([
            'view_service_requests',
            'view_rehabilitation_cases',
            'view_complaints',
            'view_dashboard', 'view_reports', 'export_reports',
        ]);

        // 5. Operator Kecamatan / Desa
        $operatorDesa = Role::firstOrCreate(['name' => 'operator_desa', 'guard_name' => 'web']);
        $operatorDesa->syncPermissions([
            'view_service_requests', 'create_service_requests',
            'view_complaints',
            'view_information_pages',
            'view_dashboard',
        ]);

        // 6. Warga / Pemohon (Public Citizen)
        $masyarakat = Role::firstOrCreate(['name' => 'masyarakat', 'guard_name' => 'web']);
        $masyarakat->syncPermissions([
            'view_service_requests', 'create_service_requests',
            'view_information_pages',
        ]);

        // Assign roles to seeded users
        $userAssignments = [
            'admin@dinsos.blitarkab.go.id' => 'super_admin',
            'petugas.dtsen@dinsos.blitarkab.go.id' => 'petugas',
            'petugas.pbi@dinsos.blitarkab.go.id' => 'petugas',
            'petugas.rehsos@dinsos.blitarkab.go.id' => 'petugas',
            'petugas.pengaduan@dinsos.blitarkab.go.id' => 'petugas',
            'kadis@dinsos.blitarkab.go.id' => 'pejabat',
            'kabid.dayasos@dinsos.blitarkab.go.id' => 'pejabat',
            'kabid.rehsos@dinsos.blitarkab.go.id' => 'pejabat',
            'kabid.linjamsos@dinsos.blitarkab.go.id' => 'pejabat',
            'sekdin@dinsos.blitarkab.go.id' => 'pejabat',
            'pimpinan@blitarkab.go.id' => 'pimpinan',
            'operator.kanigoro@blitarkab.go.id' => 'operator_desa',
            'operator.satreyan@blitarkab.go.id' => 'operator_desa',
            'operator.srengat@blitarkab.go.id' => 'operator_desa',
            'warga.budi@gmail.com' => 'masyarakat',
            'warga.siti@gmail.com' => 'masyarakat',
            'warga.joko@gmail.com' => 'masyarakat',
        ];

        foreach ($userAssignments as $email => $roleName) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->assignRole($roleName);
            }
        }
    }
}
