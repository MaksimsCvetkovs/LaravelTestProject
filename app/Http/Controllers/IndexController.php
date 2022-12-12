<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Manf;
use App\Models\Project;
use App\Models\Service;

class IndexController extends Controller {

    public function index(Request $request) {
        return view("index");
    }

    public function services(Request $request) {
        $servicesQuery = Service::query()
            ->withCount("printers")
            ->where("hidden", false)
            ->where("deleted", false);

        $paginator = $servicesQuery->paginate(4);

        return view("service.list", ["paginator" => $paginator]);
    }

    public function serviceView(Request $request, $serviceId) {
        $service = Service::query()
            ->with([
                "manf",
                "printers",
            ])
            ->findOrFail($serviceId);

        if ($service->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if (!$user) {
            if ($service->hidden) {
                abort(404);
            }
        }

        $canEdit = $user && $service->manf->canEdit($user);

        if ($user) {
            if (!$canEdit && $service->hidden) {
                abort(404);
            }
        }

        $paginator = $service->printers()->paginate(4);

        return view("service.view", [
            "service" => $service,
            "paginator" => $paginator,
        ]);
    }

    public function manfs(Request $request) {
        $manfsQuery = Manf::query()
            ->where("hidden", false)
            ->where("deleted", false);

        $paginator = $manfsQuery->paginate(4);

        return view("manf.list", ["paginator" => $paginator]);
    }

    public function projects(Request $request) {
        $projectsQuery = Project::query()
            ->withCount("models")
            ->whereHas("models")
            ->where("hidden", false)
            ->where("deleted", false);

        $paginator = $projectsQuery->paginate(4);

        return view("project.list", ["paginator" => $paginator]);
    }

    public function projectView(Request $request, $projectId) {
        $project = Project::query()
            ->findOrFail($projectId);

        if ($project->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if (!$user) {
            if ($project->hidden) {
                abort(404);
            }
        }

        $isCreator = $user && $project->canEdit($user);

        if ($user) {
            if (!$isCreator && $project->hidden) {
                abort(404);
            }
        }

        $paginator = $project->models()->paginate(6);

        return view("project.view", [
            "project" => $project,
            "paginator" => $paginator,
        ]);
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
