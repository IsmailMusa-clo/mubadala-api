<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::create([
            'name' => 'عرض ادمن',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'انشاء ادمن',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'تعديل ادمن',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف ادمن',
            'guard_name' => 'admin',
        ]);


        Permission::create([
            'name' => 'عرض الصلاحيات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'انشاء الصلاحيات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'تعديل الصلاحيات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف الصلاحيات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض الادوار',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'انشاء الادوار',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'تعديل الادوار',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف الادوار',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض المستخدمين',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'تعديل المستخدمين',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف المستخدمين',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض التصنيفات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'انشاء التصنيفات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'تعديل التصنيفات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف التصنيفات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض المنتجات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف المنتجات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض العروض',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف العروض',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض المحادثات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف المحادثات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض الاشعارات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف الاشعارات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'عرض طلبات التواصل',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'الرد على طلبات التواصل',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'حذف طلبات التواصل',
            'guard_name' => 'admin',
        ]);
    }
}
