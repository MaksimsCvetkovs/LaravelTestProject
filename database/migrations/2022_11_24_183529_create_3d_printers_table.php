<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

return new class extends Migration {
    public function up()
    {
        Schema::create('3d_printers', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->boolean('default')->index();
            $table->string('name', 255);
            $table->string('manf', 255);
            $table->text('descr');
            $table->unsignedDecimal("max_width", 8, 2);
            $table->unsignedDecimal("max_height", 8, 2);
            $table->unsignedDecimal("max_length", 8, 2);
            $table->timestamp('created_at');
            $table->unsignedInteger('created_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users');
        });

        DB::table("3d_printers")->insert([
            [
                "default" => true,
                "name" => "Original Prusa i3 MK3S+ 3D printer",
                "manf" => "Prusa",
                "descr" => "Original Prusa i3 MK3S+ 3D printer",
                "max_width" => 250,
                "max_height" => 210,
                "max_length" => 210,
                "created_at" => Carbon::now(),
            ],
            [
                "default" => true,
                "name" => "CR-10 Smart Pro",
                "manf" => "Creality",
                "descr" => "CR-10 Smart Pro",
                "max_width" => 300,
                "max_height" => 400,
                "max_length" => 400,
                "created_at" => Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('3d_printers');
    }
};
