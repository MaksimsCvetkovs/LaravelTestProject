<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer3D extends Model {

    use HasFactory;

    public $timestamps = false;

    protected $table = "3d_printers";
}
