<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Manf;
use App\Models\ManfRole;
use App\Models\Model3D;
use App\Models\Project;
use App\Models\Service;

use Carbon\Carbon;

class UserController extends Controller {

    public function serviceDelete(Request $request, $serviceId) {
        $service = Service::findOrFail($serviceId);
        $manf = $this->findEditManf($service->manf_id);

        return view("user.service.delete", [
            "service" => $service,
        ]);
    }

    public function serviceDeletePost(Request $request, $serviceId) {
        $service = Service::findOrFail($serviceId);
        $manf = $this->findEditManf($service->manf_id);

        $service->deleted = true;
        $service->save();

        return redirect()->route("user.manf.edit", ["manfId" => $manf->id]);
    }

    public function serviceEdit(Request $request, $serviceId) {
        $service = Service::findOrFail($serviceId);
        $manf = $this->findEditManf($service->manf_id);

        return view("user.service.edit", [
            "service" => $service,
        ]);
    }
}
