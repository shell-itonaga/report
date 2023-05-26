<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('id')->primary()->unsigned()->comment('ユーザID');
            $table->string('name')->comment('ユーザ名');
            $table->string('name_kana')->comment('ユーザ名(カナ)');
            $table->string('email')->unique()->nullable()->default(NULL)->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス認証日時');
            $table->string('password')->comment('パスワード');
            $table->integer('user_authority')->comment('ユーザ権限');
            $table->boolean('user_status')->default(true)->comment('ユーザ状態');
            $table->boolean('is_delete_flg')->default(false)->comment('削除フラグ');
            $table->dateTime('last_login')->nullable()->default(NULL)->comment('最終ログイン日時');
            $table->string('api_token',60)->unique()->nullable();
            $table->rememberToken()->comment('トークン記憶');
            $table->integer('last_update_user_id')->unsigned()->comment('最終更新者ID');
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
