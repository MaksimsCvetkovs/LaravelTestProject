<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statusses', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('name', 255);
            $table->string('manf_descr', 255);
            $table->string('user_descr', 255);
        });

        DB::table('order_statusses')->insert([
            ['name' => 'Izveidots', 'manf_descr' => 'Izveidots', 'user_descr' => 'Izveidots'],
            ['name' => 'Apstiprināts', 'manf_descr' => 'Apstiprināts', 'user_descr' => 'Izveidots'],
            ['name' => 'Pabeigts', 'manf_descr' => 'Pabeigts', 'user_descr' => 'Izveidots'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses');
    }
};
