<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manf extends Model {

    use HasFactory;

    public $timestamps = false;

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function roles() {
        return $this->hasMany(ManfRole::class);
    }

    public function canEdit(User $user) {
        $manfRoleQuery = $this->roles()
            ->where("deleted", false)
            ->where("can_edit", true)
            ->whereHas("users", function ($query) use ($user) {
                $query->where("user_id", $user->id);
            });

        return !!$manfRoleQuery->first();
    }
}
