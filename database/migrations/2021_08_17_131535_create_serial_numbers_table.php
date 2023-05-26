<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('serial_no', 32)->unique()->comment('製番');
            $table->string('serial_name', 128)->comment('製番品名');
            $table->string('order_no', 32)->comment('受注No');
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
        Schema::dropIfExists('serial_numbers');
    }
}
