<?php

namespace App\Console\Commands;

use App\Permission;
use App\Role;
use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install eeyes account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $role = Role::firstOrNew([
            'name' => 'eeyes.website.account.verified_developer',
            'display_name' => 'e瞳用户中心认证用户',
            'description' => 'e瞳用户中心认证用户在应用授权时，开发者后面会有“认证用户”字样，没有此权限的显示为“非认证用户”',
        ]);
        if ($role->exists) {
            $this->warn("Role '{$role->name}' already exists. (id = {$role->id})");
        } else {
            $role->save();
            $this->info("Role '{$role->name}' created. (id = {$role->id})");
        }

        $role = Role::firstOrNew([
            'name' => 'eeyes.website.account.admin',
            'display_name' => 'e瞳统一账户管理系统后台管理权限',
            'description' => '可以执行e瞳统一账户管理系统后台管理的任何操作',
        ]);
        if ($role->exists) {
            $this->warn("Role '{$role->name}' already exists. (id = {$role->id})");
        } else {
            $role->save();
            $this->info("Role '{$role->name}' created. (id = {$role->id})");
        }

        $permission = Permission::firstOrNew([
            'name' => 'eeyes.website.account.admin',
            'display_name' => 'e瞳统一账户管理系统后台管理权限',
            'description' => '可以执行e瞳统一账户管理系统后台管理的任何操作',
        ]);
        if ($permission->exists) {
            $this->warn("Permission '{$permission->name}' already exists. (id = {$permission->id})");
        } else {
            $permission->save();
            $this->info("Permission '{$permission->name}' created. (id = {$permission->id})");
        }

        if ($role->hasPermission($permission->name)) {
            $this->warn("Role '{$role->name}' already has permission '{$permission->name}'.");
        } else {
            $role->attachPermission($permission);
            $this->info("Role '{$role->name}' attached permission '{$permission->name}'.");
        }
    }
}
