<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {

    use HasFactory;

    public $timestamps = false;

    public function manf() {
        return $this->belongsTo(Manf::class);
    }

    public function printers() {
        return $this->belongsToMany(Printer3D::class, table: "service_3d_printers", relatedPivotKey: "3d_printer_id");
    }

    public function canEdit(User $user) {
        return $this->manf->canEdit($user);
    }
}
