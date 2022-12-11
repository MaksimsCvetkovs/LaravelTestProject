<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;

class IndexController extends Controller {

    public function index(Request $request) {
        return view("index");
    }

    public function projects(Request $request) {
        $projectsQuery = Project::where("hidden", false)->where("deleted", false);

        $paginator = $projectsQuery->paginate(10);

        return view("project.list", ["paginator" => $paginator]);
    }

    public function projectView(Request $request, $projectId) {
        $project = Project::findOrFail($projectId);

        if ($project->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if (!$user) {
            if ($project->hidden) {
                abort(404);
            }
        }

        $isCreator = $project->created_by != $user->id;

        if ($user) {
            if ($isCreator) {
                abort(404);
            }
        }

        return view("project.view", ["project" => $project]);
    }

    public function projectViewPost(Request $request, $projectId) {
        abort(404);
    }

    public function suppliers(Request $request) {
        /*$suppliers = Supplier::with([
            "userRoles",
            "userRoles.users",
        ])->get();

        return view("supplier.list", [
            "suppliers" => $suppliers,
        ]);*/
        abort(404);
    }

    public function supplierCreate(Request $request) {
        $user = auth()->user();

        if (!$user) {
            abort(404);
        }

        if ($request->isMethod("GET")) {
            return view("supplier.create");
        } else if ($request->isMethod("POST")) {
            $data = $request->validate([
                "name" => "required|max:256",
                "descr" => "required|max:1024",
            ]);

            $supplier = new Supplier;
            $supplier->name = $data["name"];
            $supplier->descr = $data["descr"];
            $supplier->save();

            $supplierUserRole = new SupplierUserRole;
            $supplierUserRole->name = "Creator";
            $supplier->userRoles()->save($supplierUserRole);

            $supplierUser = new SupplierUser;
            $supplierUser->user_id = $user->id;
            $supplierUserRole->users()->save($supplierUser);

            return redirect()->route("supplier.view", ["supplierId" => $supplier->id]);
        }
    }

    public function supplierView(Request $request, $supplierId) {
        $user = auth()->user();

        $supplier = Supplier::with(
            "userRoles",
            "userRoles.users",
            "userRoles.users.user",
        )->findOrFail($supplierId);

        $canEdit = $supplier->canEdit($user);

        if ($request->isMethod("GET")) {
            if ($canEdit) {
                return view("supplier.manage", ["supplier" => $supplier]);
            }

            return view("supplier.view", ["supplier" => $supplier]);
        } else if ($request->isMethod("POST")) {
            if ($canEdit) {
                $type = $request->input("type");

                if ($type == "edit") {
                    $data = $request->validate([
                        "name" => "required|max:256",
                        "descr" => "required|max:1024",
                    ]);

                    $supplier->name = $data["name"];
                    $supplier->descr = $data["descr"];

                    if ($supplier->isDirty()) {
                        $supplier->save();
                    }

                    return redirect()->route("supplier.view", ["supplierId" => $supplierId]);
                } else if ($type == "delete") {
                    $supplier->delete();

                    return redirect()->route("supplier.list");
                }

                abort(404);
            }
        }
    }
}
