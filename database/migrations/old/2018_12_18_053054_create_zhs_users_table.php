<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZhsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zhs_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('用户名,手机号');
            //$table->string('email')->unique()->comment('邮箱');
            $table->string('usercode')->unique()->comment('选手编号');
            $table->string('password')->comment('密码');
            $table->tinyInteger('status')->default(1)->comment('状态1正常(def),0禁止');
            $table->rememberToken();
            $table->timestamps();
            $table->comment = '中华诵用户登录表';
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zhs_users');
    }
}
