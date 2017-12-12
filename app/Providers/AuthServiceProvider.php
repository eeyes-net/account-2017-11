<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensCan([
            'info-username.read' => '获取您的用户名（NetID）',
            'info-user_id.read' => '获取您的学工号',
            'info-name.read' => '获取您的姓名',
            'info-email.read' => '获取您的邮箱',
            'info-email.write' => '修改您的邮箱',
            'info-mobile.read' => '获取您的电话号码',
            'info-mobile.write' => '修改您的电话号码',
            'info-school.read' => '获取您的学院、专业、班级',
            'info-detail.read' => '获取您的性别、生日、宿舍、民族、籍贯等信息',
            'info-secret.read' => '获取您的身份证信息',
            'role.read' => '查询您是否有是某角色',
            'permission.read' => '查询您是否有某使用e瞳API权限',
            'admin.write' => '后台管理API使用权限',
        ]);
    }
}
