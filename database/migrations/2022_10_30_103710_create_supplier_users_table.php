<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\SupplierUserRole;
use App\Models\User;

return new class extends Migration {
    public function up() {
        Schema::create("supplier_users", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SupplierUserRole::class);
            $table->foreignIdFor(User::class);
        });
    }

    public function down() {
        Schema::dropIfExists("supplier_users");
    }
};
