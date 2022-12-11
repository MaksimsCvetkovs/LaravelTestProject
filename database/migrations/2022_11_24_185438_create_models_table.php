<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create("models", function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->string("name", 255);
            $table->text("descr");
            $table->timestamp("created_at");
            $table->unsignedInteger("created_by");
            $table->boolean("deleted")->index();
            $table->boolean("hidden")->index();
            $table->unsignedDecimal("width", 8, 2);
            $table->unsignedDecimal("height", 8, 2);
            $table->unsignedDecimal("length", 8, 2);

            $table->foreign("created_by")->references("id")->on("users");
        });
    }

    public function down() {
        Schema::dropIfExists("models");
    }
};
