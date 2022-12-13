<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Manf;

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
        return view("user.manf.create");
    }

    public function manfCreatePost(Request $request) {
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
