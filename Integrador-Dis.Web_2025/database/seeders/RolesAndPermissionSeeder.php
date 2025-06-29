<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles -> Admin, Teacher, Student
        // Permissions -> Create, Read, Update, Delete

        $roles = ['admin', 'teacher', 'student'];
        $permissions = [
            'course-create',
            'course-read',
            'course-update',
            'course-delete',
            'category-create',
            'category-read',
            'category-update',
            'category-delete',
            'user-create',
            'user-read',
            'user-update',
            'user-delete',
            'role-create',
            'role-read',
            'role-update',
            'role-delete',
            'permission-create',
            'permission-read',
            'permission-update',
            'permission-delete',
            'profile-update',
            'profile-read',
        ];

        // Create roles
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $teacherRole = Role::findByName('teacher');
        $studentRole = Role::findByName('student');

        $adminPermissions = Permission::all();

        $teacherPermissions = Permission::where('name', 'like', 'course-%')
            ->orWhere('name', 'like', 'category-%')
            ->orWhere('name', 'profile-%')
            ->get();

        $studentPermissions = Permission::where('name', 'like', 'profile-%')
            ->orWhere('name', 'like', 'course-read')
            ->get();

        // Assign permissions to admin
        foreach ($adminPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
        
        // Assign permissions to teacher
        foreach ($teacherPermissions as $permission) {
            $teacherRole->givePermissionTo($permission);
        }

        // Assign permissions to student
        foreach ($studentPermissions as $permission) {
            $studentRole->givePermissionTo($permission);
        }

        //dummy admin-user
        $dummyAdmin = User::firstOrCreate(
            ['email' => 'admin@dummy.com'],
            [
                'name' => 'DummyAdmin',
                'surname' => 'Test',
                'gender' => 'Masculino',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'dni' => '12345678',
                'phone' => '1234567890',
                'address' => '123 Admin St',
                'birth_date' => '1990-01-01'
            ]
        );
        $dummyAdmin->assignRole('admin');

        //dummy teacher-user
        $dummyTeacher = User::firstOrCreate(
            ['email' => 'teacher@dummy.com'],
            [
                'role' => 'teacher',
                'dni' => '87654321',
                'name' => 'DummyTeacher',
                'surname' => 'Test',
                'gender' => 'Masculino',
                'birth_date' => '1992-02-02',
                'address' => '456 Teacher Ave',
                'phone' => '0987654321',
                'password' => bcrypt('teacher123'),
            ]
        );
        $dummyTeacher->assignRole('teacher');

        //dummy student-user
        $dummyStudent = User::firstOrCreate(
            ['email' => 'student@dummy.com'],
            [
                'name' => 'DummyStudent',
                'surname' => 'Test',
                'gender' => 'Femenino',
                'password' => bcrypt('student123'),
                'role' => 'student',
                'dni' => '11223344',
                'phone' => '1122334455',
                'address' => '789 Student Blvd',
                'birth_date' => '1995-03-03'
            ]
        );
        $dummyStudent->assignRole('student');
    }
}
