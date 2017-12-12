<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;

class InstallAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:admin {net_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user by net_id and set him/her to admin of eeyes account website';

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
        $net_id = $this->argument('net_id');
        $user = User::whereUsername($net_id)->first();
        if ($user) {
            $this->warn("User '{$user->username}' already exists.");
        } else {
            $user = User::newByNetId($net_id);
            $this->info("Get user '{$user->username}' info OK.");
            $user->save();
            $this->info("User saved. (id = {$user->id})");
        }
        $this->info("Name: {$user->name}");
        $this->info("User ID: {$user->user_id}");
        $this->info("E-mail: {$user->email}");
        $role = Role::whereName('eeyes.website.account.admin')->first();
        if ($user->can('eeyes.website.account.admin')) {
            $this->warn("The user is already an admin.");
        } else {
            $user->attachRole($role);
            $this->info("Set as admin OK.");
        }
    }
}
