<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManfRole extends Model {

    use HasFactory;

    public $timestamps = false;

    public function users() {
        return $this->belongsToMany(User::class, table: "manf_users");
    }
}
