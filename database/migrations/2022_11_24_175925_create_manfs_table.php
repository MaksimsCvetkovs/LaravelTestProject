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
        Schema::create("manfs", function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->string("name", 255);
            $table->text("descr");
            $table->string("email", 255);
            $table->boolean("deleted")->index();
            $table->boolean("hidden")->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("manfs");
    }
};
