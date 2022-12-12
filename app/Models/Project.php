<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    use HasFactory;

    public $timestamps = false;

    public function models() {
        return $this->belongsToMany(Model3D::class, table: "project_models", relatedPivotKey: "model_id");
    }

    public function canEdit(User $user) {
        return !$this->deleted && $this->created_by == $user->id;
    }
}
