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
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('manf_service_id');
            $table->unsignedInteger('user_address_id');
            $table->unsignedSmallInteger('latest_order_status_id')->nullable();
            $table->boolean("deleted")->index();

            $table->foreign('manf_service_id')->references('id')->on('services');
            $table->foreign('user_address_id')->references('id')->on('user_addresses');
            $table->foreign('latest_order_status_id')->references('id')->on('order_statusses');
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
};
