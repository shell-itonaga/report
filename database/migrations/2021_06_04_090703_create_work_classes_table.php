<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_classes', function (Blueprint $table) {
            $table->increments('id')->unsigned()->comment('作業区分コード');
            $table->string('work_class_name',100)->comment('作業区分名');
            $table->integer('work_type_id')->unsigned()->index()->comment('作業分類コード');
            $table->boolean('is_delete_flg')->default(false)->comment('削除フラグ');
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
        Schema::dropIfExists('work_classes');
    }
}
