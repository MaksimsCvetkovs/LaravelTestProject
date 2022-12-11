<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('order_id');
            $table->unsignedSmallInteger('order_status_id');
            $table->timestamp('created_at');
            $table->unsignedInteger('created_by');
            $table->boolean("deleted")->index();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('order_status_id')->references('id')->on('order_statusses');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_history');
    }
};
