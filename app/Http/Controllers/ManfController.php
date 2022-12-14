<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Manf;
use App\Models\ManfRole;

class ManfController extends Controller {

    public static function findEditManf($manfId) {
        $manf = Manf::findOrFail($manfId);

        if ($manf->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if (!$user || !$manf->canEdit($user)) {
            abort(404);
        }

        return $manf;
    }

    public static function validateManfData(Request $request) {
        $data = $request->validate([
            "name" => "required|min:4|max:50",
            "descr" => "max:65535",
            "email" => "required|email",
        ]);

        if (!$data["descr"]) {
            $data["descr"] = "";
        }

        return $data;
    }

    public static function validateRoleData(Request $request) {
        $data = $request->validate([
            "name" => "required|min:2|max:100",
        ]);

        $data["can_edit"] = $request->boolean("can_edit");

        return $data;
    }

    public function manfsMy(Request $request) {
        $user = auth()->user();
        $manfsQuery = Manf::query()
            ->whereHas("roles", function ($query) use ($user) {
                $query->where("deleted", false);
                $query->whereHas("users", function ($query) use ($user) {
                    $query->where("user_id", $user->id);
                });
            })
            ->where("deleted", false);

        $paginator = $manfsQuery->paginate(4);

        return view("user.manf.list", ["paginator" => $paginator]);
    }

    public function manfEdit(Request $request, $manfId) {
        $manf = $this->findEditManf($manfId);

        $paginator = $manf->services()
            ->where("deleted", false)
            ->paginate(4);

        return view("user.manf.edit", [
            "manf" => $manf,
            "paginator" => $paginator,
        ]);
    }

    public function manfEditPost(Request $request, $manfId) {
        $manf = $this->findEditManf($manfId);
        $data = $this->validateManfData($request);

        $manf->name = $data["name"];
        $manf->descr = $data["descr"];
        $manf->email = $data["email"];
        $manf->save();

        return redirect()->route("manf.view", ["manfId" => $manfId]);
    }

    public function manfCreate(Request $request) {
        $user = auth()->user();

        if (!$user->isVerified()) {
            abort(404);
        }

        return view("user.manf.create");
    }

    public function manfCreatePost(Request $request) {
        $user = auth()->user();

        if (!$user->isVerified()) {
            abort(404);
        }

        $data = $this->validateManfData($request);

        $manf = new Manf;
        $manf->name = $data["name"];
        $manf->descr = $data["descr"];
        $manf->email = $data["email"];
        $manf->deleted = false;
        $manf->hidden = false;
        $manf->save();

        $manfRole = new ManfRole;
        $manfRole->manf_id = $manf->id;
        $manfRole->name = "Creator";
        $manfRole->can_edit = true;
        $manfRole->deleted = false;
        $manfRole->save();

        $user = auth()->user();

        $manfRole->users()->attach($user->id);

        return redirect()->route("manf.view", ["manfId" => $manf->id]);
    }

    public function manfRoles(Request $request, $manfId) {
        $manf = $this->findEditManf($manfId);

        $paginator = $manf->roles()->paginate(6);

        return view("user.manf.role.list", [
            "manf" => $manf,
            "paginator" => $paginator,
        ]);
    }

    public function manfRoleCreate(Request $request, $manfId) {
        $manf = $this->findEditManf($manfId);
        return view("user.manf.role.create");
    }

    public function manfRoleCreatePost(Request $request, $manfId) {
        $manf = $this->findEditManf($manfId);

        $data = $this->validateRoleData($request);

        $role = new ManfRole;
        $role->manf_id = $manfId;
        $role->name = $data["name"];
        $role->can_edit = $data["can_edit"];
        $role->deleted = false;
        $role->save();

        return redirect()->route("user.manf.role.list", [
            "manfId" => $manfId,
        ]);
    }

    public static function findManfAndRole($manfId, $roleId) {
        $role = ManfRole::findOrFail($roleId);
        $manf = self::findEditManf($manfId);

        if ($role->manf_id != $manf->id) {
            abort(404);
        }

        return [$manf, $role];
    }

    public function manfRoleView(Request $request, $manfId, $roleId) {
        [$manf, $role] = $this->findManfAndRole($manfId, $roleId);

        $paginator = $role->users()->paginate(6);

        return view("user.manf.role.view", [
            "manf" => $manf,
            "role" => $role,
            "paginator" => $paginator,
        ]);
    }

    public function manfRoleEdit(Request $request, $manfId, $roleId) {
        [$manf, $role] = $this->findManfAndRole($manfId, $roleId);

        return view("user.manf.role.edit", [
            "manf" => $manf,
            "role" => $role,
        ]);
    }

    public function manfRoleEditPost(Request $request, $manfId, $roleId) {
        [$manf, $role] = $this->findManfAndRole($manfId, $roleId);

        $data = $this->validateRoleData($request);

        $role->name = $data["name"];
        $role->can_edit = $data["can_edit"];
        $role->save();

        return redirect()->route("user.manf.role.list", [
            "manfId" => $manfId,
        ]);
    }

    public function manfRoleUserAddList(Request $request, $manfId, $roleId) {
        [$manf, $role] = $this->findManfAndRole($manfId, $roleId);

        $usersQuery = User::whereDoesntHave("roles", function ($query) use ($roleId) {
            $query->where("id", $roleId);
        });

        $paginator = $usersQuery->paginate(6);

        return view("user.list", [
            "manf" => $manf,
            "role" => $role,
            "paginator" => $paginator,
        ]);
    }

    public function manfRoleUserAdd(Request $request, $manfId, $roleId, $userId) {
        [$manf, $role] = $this->findManfAndRole($manfId, $roleId);

        $role->users()->attach($userId);

        return redirect()->route("user.manf.role.view", [
            "manfId" => $manfId,
            "roleId" => $roleId,
        ]);
    }

    public function manfRoleEditUserDelete(Request $request, $manfId, $roleId, $userId) {
        [$manf, $role] = $this->findManfAndRole($manfId, $roleId);

        return view("delete", [
            "title" => $role->name,
            "message" => __("manf.role.user.delete"),
            "deleteAction" => __("manf.role.user.action.delete"),
            "cancelAction" => __("manf.role.user.action.cancel"),
        ]);
    }

    public function manfRoleEditUserDeletePost(Request $request, $manfId, $roleId, $userId) {
        [$manf, $role] = $this->findManfAndRole($manfId, $roleId);

        $role->users()->detach($userId);

        return redirect()->route("user.manf.role.view", [
            "manfId" => $manfId,
            "roleId" => $roleId,
        ]);
    }

    public function manfs(Request $request) {
        $manfsQuery = Manf::query()
            ->where("hidden", false)
            ->where("deleted", false);

        $paginator = $manfsQuery->paginate(4);

        return view("manf.list", ["paginator" => $paginator]);
    }

    public function manfView(Request $request, $manfId) {
        $manf = Manf::query()
            ->findOrFail($manfId);

        if ($manf->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if ($manf->hidden) {
            if (!$user || !$manf->canEdit($user)) {
                abort(404);
            }
        }

        $paginator = $manf->services()
            ->where("deleted", false)
            ->where("hidden", false)
            ->paginate(4);

        return view("manf.view", [
            "manf" => $manf,
            "paginator" => $paginator,
        ]);
    }
}
