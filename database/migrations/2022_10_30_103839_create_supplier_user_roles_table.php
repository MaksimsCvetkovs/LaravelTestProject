<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Supplier;

return new class extends Migration {

    public function up(){
        Schema::create("supplier_user_roles", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Supplier::class);
            $table->string("name", 128);
        });
    }

    public function down(){
        Schema::dropIfExists("supplier_user_roles");
    }
};
