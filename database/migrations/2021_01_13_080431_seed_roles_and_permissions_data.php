<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // clear cache
        app(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // create rights
        Permission::create([
            'name' => 'manage_content'
        ]);
        Permission::create([
            'name' => 'manage_users'
        ]);

        // create roles and give rights
        $admin = Role::create([
            'name' => 'admin'
        ]);
        $admin->givePermissionTo('manage_content');
        $admin->givePermissionTo('manage_users');

        $maintainer = Role::create([
            'name' => 'maintainer'
        ]);
        $maintainer->givePermissionTo('manage_content');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // clear cache
        app(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // remove all data
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
