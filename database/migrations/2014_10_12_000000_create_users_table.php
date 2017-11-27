<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->comment('NetId')->unique();
            $table->string('password');
            $table->string('user_id')->comment('学工号')->unique();
            $table->string('name')->comment('姓名')->index();
            $table->string('email')->comment('E-mail')->index();
            $table->string('mobile')->comment('手机号码')->index();
            $table->string('gender')->comment('性别（“男”或“女”）');
            $table->text('classid')->comment('班级名称');
            $table->text('dep')->comment('学院名称');
            $table->text('speciality')->comment('专业名称');
            $table->text('depid')->comment('学院id');
            $table->text('idcardname')->comment('证件类型（一般为“身份证”）');
            $table->text('idcardno')->comment('证件号码');
            $table->text('birthday')->comment('生日');
            $table->text('roomnumber')->comment('宿舍地址');
            $table->text('marriage')->comment('“已婚”或“未婚”');
            $table->text('nation')->comment('民族');
            $table->text('nationplace')->comment('籍贯');
            $table->text('polity')->comment('政治面貌（“中国共产主义青年团”“中国共产党党员”等）');
            $table->text('studenttype')->comment('考生类型（“统考本科生”等）');
            $table->text('tutoremployeeid')->comment('导师姓名');
            $table->text('usertype')->comment('身份（具体不详，可能与是教师还是学生有关）');
            $table->text('roomphone')->comment('宿舍电话（一般为null）');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
