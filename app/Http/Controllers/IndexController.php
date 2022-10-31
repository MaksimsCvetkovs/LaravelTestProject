<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Supplier;
use App\Models\SupplierUser;
use App\Models\SupplierUserRole;

class IndexController extends Controller {

    public function index() {
        return view("index");
    }

    public function suppliers(Request $request) {
        $suppliers = Supplier::with([
            "userRoles",
            "userRoles.users",
        ])->get();

        return view("supplier.list", [
            "suppliers" => $suppliers,
        ]);
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
