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
        Schema::create('manf_users', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('manf_role_id');
    
            $table->primary(['user_id', 'manf_role_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('manf_role_id')->references('id')->on('manf_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manf_users');
    }
};
