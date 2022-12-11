<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model3D extends Model {

    use HasFactory;

    public $timestamps = false;

    protected $table = "models";
}
