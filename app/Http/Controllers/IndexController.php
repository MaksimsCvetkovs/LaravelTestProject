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
            ->with("manf")
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

        if (!$user && $service->hidden) {
            abort(404);
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
}
