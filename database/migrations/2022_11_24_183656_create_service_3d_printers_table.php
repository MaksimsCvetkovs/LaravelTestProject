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
        Schema::create('service_3d_printers', function (Blueprint $table) {
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('3d_printer_id');

            $table->primary(['service_id', '3d_printer_id']);
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('3d_printer_id')->references('id')->on('3d_printers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_3d_printers');
    }
};
