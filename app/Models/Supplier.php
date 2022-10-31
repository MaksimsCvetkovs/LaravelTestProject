<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

    use HasFactory;

    public $timestamps = false;

    public function userRoles() {
        return $this->hasMany(SupplierUserRole::class);
    }

    public function canEdit(User $user) {
        return $this->userRoles->contains(
            fn ($userRole) => $userRole->users->contains(
                fn ($supplierUser) => $supplierUser->user_id == $user->id
            )
        );
    }
}
