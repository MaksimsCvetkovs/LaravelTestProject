<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model3D extends Model {

    use HasFactory;

    public $timestamps = false;

    protected $table = "models";

    public function projects() {
        return $this->belongsToMany(Project::class, table: "project_models", foreignPivotKey: "model_id");
    }

    public function canEdit(User $user) {
        return !$this->deleted && $this->created_by == $user->id;
    }
}
