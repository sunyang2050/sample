<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZhsUsersDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zhs_users_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('realname')->comment('真实姓名');
            //省市县
            $table->tinyInteger('province')->nullable()->comment('所属赛区省');
            $table->tinyInteger('city')->nullable()->comment('所属赛区市');
            $table->tinyInteger('county')->nullable()->comment('所属赛区县');

            $table->enum('sex',[1,2])->nullable()->comment('性别1男2女');
            $table->tinyInteger('age')->nullable()->comment('年龄');
            $table->string('nation')->nullable()->comment('民族');
            $table->tinyInteger('identity_type')->comment('身份类型1身份证def,2护照');
            $table->string('identity')->comment('身份证或护照号码');
            $table->string('brief')->comment('个人特长');

            $table->string('email')->unique()->comment('邮箱');

            $table->tinyInteger('addr_province')->nullable()->comment('通讯地址省');
            $table->tinyInteger('addr_city')->nullable()->comment('通讯地址市');
            $table->tinyInteger('addr_county')->nullable()->comment('通讯地址县');
            $table->string('addr_info')->comment('详细地址');
            $table->string('zipcode')->comment('邮编');

            $table->tinyInteger('uid')->nullable()->comment('关联zhs_users表ID');
            $table->foreign('uid')->references('id')->on('zhs_users')->comment('关联zhs_users表ID');

            $table->rememberToken();
            $table->timestamps();
            $table->comment = '中华诵用户详情表';
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
        Schema::dropIfExists('zhs_users_detail');
    }
}
