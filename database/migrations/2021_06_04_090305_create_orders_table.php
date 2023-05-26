<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('order_no', 32)->unique()->comment('受注No');
            $table->string('order_name', 128)->comment('受注品名');
            $table->string('customer_code', 128)->comment('得意先コード');
            $table->boolean('is_complete_flg')->default(false)->comment('完了フラグ');
            $table->date('sales_complete_date')->nullable()->comment('売上完了日');
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
        Schema::dropIfExists('orders');
    }
}
