<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $create_task_permission=Permission::create(['name'=>'create task']);
        $update_task_permission=Permission::create(['name'=>'update task']);
        $delete_task_permission=Permission::create(['name'=>'delete task']);
        $see_task_permission=Permission::create(['name'=>'see task']);
        $see_all_tasks_permission=Permission::create(['name'=>'see all tasks']);
        $check_task_permission=Permission::create(['name'=>'check task']);
       
        $admin_role = Role::create(['name'=>'admin']);
        $admin_role->givePermissionTo(Permission::all());

        $worker_role = Role::create(['name'=>'worker']);

        $worker_role->givePermissionTo($check_task_permission,$see_task_permission);
        
    }
}
