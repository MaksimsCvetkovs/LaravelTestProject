<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Service;

class ServiceController extends Controller {

    public static function validateServiceData(Request $request) {
        $data = $request->validate([
            "name" => "required|min:4|max:100",
            "descr" => "max:65535",
        ]);

        return $data;
    }

    public function serviceDelete(Request $request, $serviceId) {
        $service = Service::findOrFail($serviceId);
        $manf = ManfController::findEditManf($service->manf_id);

        return view("delete", [
            "title" => $service->name,
            "message" => __("service.message.delete"),
            "deleteAction" => __("service.action.delete"),
            "cancelAction" => __("service.action.cancel"),
        ]);
    }

    public function serviceDeletePost(Request $request, $serviceId) {
        $service = Service::findOrFail($serviceId);
        $manf = ManfController::findEditManf($service->manf_id);

        $service->deleted = true;
        $service->save();

        return redirect()->route("user.manf.edit", ["manfId" => $manf->id]);
    }

    public function serviceCreate(Request $request, $manfId) {
        $manf = ManfController::findEditManf($manfId);
        return view("user.service.create");
    }

    public function serviceCreatePost(Request $request, $manfId) {
        $manf = ManfController::findEditManf($manfId);

        $data = $this->validateServiceData($request);

        $user = auth()->user();

        $service = new Service;
        $service->manf_id = $manfId;
        $service->name = $data["name"];
        $service->descr = $data["descr"];
        $service->created_by = $user->id;
        $service->deleted = false;
        $service->hidden = false;
        $service->save();

        return redirect()->route("service.view", ["serviceId" => $service->id]);
    }

    public function serviceEdit(Request $request, $serviceId) {
        $service = Service::findOrFail($serviceId);
        $manf = ManfController::findEditManf($service->manf_id);

        $paginator = $service->printers()->paginate(6);

        return view("user.service.edit", [
            "service" => $service,
            "paginator" => $paginator,
        ]);
    }

    public function serviceEditPost(Request $request, $serviceId) {
        $service = Service::findOrFail($serviceId);
        $manf = ManfController::findEditManf($service->manf_id);

        $data = $this->validateServiceData($request);

        $service->name = $data["name"];
        $service->descr = $data["descr"];
        $service->save();

        return redirect()->route("service.view", [
            "serviceId" => $serviceId,
        ]);
    }

    public function serviceEditPrinterDelete(Request $request, $serviceId, $printerId) {
        $service = Service::findOrFail($serviceId);
        $manf = ManfController::findEditManf($service->manf_id);

        $service->printers()->detach($printerId);

        return redirect()->route("user.service.edit", [
            "serviceId" => $serviceId,
        ]);
    }

    public function services(Request $request) {
        $nameSearch = $request->input("name_search");

        $servicesQuery = Service::query()
            ->with("manf")
            ->withCount("printers")
            ->where("hidden", false)
            ->where("deleted", false);

        if ($nameSearch) {
            $servicesQuery->where("name", "like", "%$nameSearch%");
        }

        $paginator = $servicesQuery->paginate(4)->withQueryString();

        return view("service.list", [
            "paginator" => $paginator,
            "nameSearch" => $nameSearch,
        ]);
    }

    public function servicesPost(Request $request) {
        return redirect()->route("service.list", ["name_search" => $request->input("name_search")]);
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

        if (!$user && $service->hidden) {
            abort(404);
        }

        $canEdit = $user && $service->manf->canEdit($user);

        if ($user) {
            if (!$canEdit && $service->hidden) {
                abort(404);
            }
        }

        $paginator = $service->printers()->paginate(4)->withQueryString();

        return view("service.view", [
            "service" => $service,
            "paginator" => $paginator,
        ]);
    }
}
