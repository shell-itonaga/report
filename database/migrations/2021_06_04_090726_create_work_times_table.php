<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->increments('id')->unsigned()->comment('作業コード');
            $table->integer('user_id')->unsigned()->index()->comment('ユーザID');
            $table->string('customer_code')->index()->comment('得意先コード');
            $table->integer('order_id')->unsigned()->index()->comment('受注ID');
            $table->integer('serial_id')->unsigned()->index()->comment('製番ID');
            $table->string('device_name')->nullable()->default(NULL)->comment('型式');
            $table->integer('unit_id')->unsigned()->index()->comment('号機ID');
            $table->integer('work_type_id')->unsigned()->index()->comment('作業分類コード');
            $table->integer('work_class_id')->unsigned()->index()->comment('作業区分コード');
            $table->integer('work_detail_id')->unsigned()->index()->comment('作業内容コード');
            $table->string('unit_name', 50)->nullable()->default(NULL)->comment('ユニット名');
            $table->date('work_date')->comment('作業日付');
            $table->decimal('work_time', 5, 2)->comment('作業時間');
            $table->string('remarks', 512)->nullable()->default(NULL)->comment('備考');
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
        Schema::dropIfExists('work_times');
    }
}
