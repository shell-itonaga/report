<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnitNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_numbers', function (Blueprint $table) {
            $table->increments('id')->comment('号機ID');
            $table->string('unit_no_name', 100)->comment('号機名');
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
        Schema::dropIfExists('unit_numbers');
    }
}
