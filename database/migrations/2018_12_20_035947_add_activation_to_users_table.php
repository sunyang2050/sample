<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*
     * $ git checkout master
       $ git checkout -b account-activation-password-resets
     *
     * $ php artisan make:migration add_activation_to_users_table --table=users
     *
     * php artisan migrate
     *
     * $ php artisan migrate:refresh 重置数据
       $ php artisan db:seed 填充数据
       =($ php artisan migrate:refresh --seed )
     * */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('activation_token')->nullable();
            $table->boolean('activated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('activation_token');
            $table->dropColumn('activated');
        });
    }
}
