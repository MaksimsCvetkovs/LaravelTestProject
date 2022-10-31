<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierUserRole extends Model {

    use HasFactory;

    public $timestamps = false;

    public function users() {
        return $this->hasMany(SupplierUser::class);
    }
}
