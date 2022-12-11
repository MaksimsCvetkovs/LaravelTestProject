<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up() {
         Schema::create("user_groups", function (Blueprint $table) {
            $table->unsignedTinyInteger("id");
            $table->string("name", 255);

            $table->primary("id");
        });

        Schema::table("users", function (Blueprint $table) {
            $table->unsignedTinyInteger("user_group_id")->after("email");
            $table->foreign("user_group_id")->references("id")->on("user_groups");
        });

        DB::table("user_groups")->insert([
            ["id" => 1, "name" => "user"],
            ["id" => 2, "name" => "moder"],
            ["id" => 3, "name" => "admin"],
            ["id" => 4, "name" => "dev"],
        ]);
    }

    public function down() {
        Schema::table("users", function (Blueprint $table) {
            $table->dropForeign("users_user_group_id_foreign");
            $table->dropColumn("user_group_id");
        });

        Schema::dropIfExists("user_groups");
    }
};
