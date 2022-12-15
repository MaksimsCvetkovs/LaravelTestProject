<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Model3D;

use Carbon\Carbon;

class Model3DController extends Controller {

    public static function findEditModel($modelId) {
        $model = Model3D::findOrFail($modelId);

        if ($model->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if (!$user || !$model->canEdit($user)) {
            abort(404);
        }

        return $model;
    }

    public static function findViewModel($modelId) {
        $model = Model3D::findOrFail($modelId);

        if ($model->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if ($model->hidden && !$model->canEdit($user)) {
            abort(404);
        }

        return $model;
    }

    public static function validateModelData(Request $request) {
        $data = $request->validate([
            "name" => "required|min:4|max:50",
            "descr" => "max:65535",
            "width" => "required|numeric|min:1",
            "height" => "required|numeric|min:1",
            "length" => "required|numeric|min:1",
        ]);

        $data["hidden"] = $request->boolean("hidden");

        return $data;
    }

    public function modelsMy(Request $request) {
        $nameSearch = $request->input("name_search");

        $user = auth()->user();

        $modelsQuery = Model3D::query()
            ->where("created_by", $user->id)
            ->where("deleted", false);

        if ($nameSearch) {
            $modelsQuery->where("name", "like", "%$nameSearch%");
        }

        $paginator = $modelsQuery->paginate(4)->withQueryString()->withQueryString();

        return view("model.list", [
            "paginator" => $paginator,
            "my" => true,
            "nameSearch" => $nameSearch,
        ]);
    }

    public function modelsMyPost(Request $request) {
         return redirect()->route("user.project.my", ["name_search" => $request->input("name_search")]);
    }

    public function modelCreate(Request $request) {
        return view("user.model.create");
    }

    public function modelEdit(Request $request, $modelId) {
        $model = $this->findEditModel($modelId);
        return view("user.model.edit", ["model" => $model]);
    }

    public function modelEditPost(Request $request, $modelId) {
        $model = $this->findEditModel($modelId);
        $data = $this->validateModelData($request);

        $model->name = $data["name"];
        $model->descr = $data["descr"];
        $model->hidden = $data["hidden"];
        $model->width = $data["width"];
        $model->height = $data["height"];
        $model->length = $data["length"];
        $model->save();

        return redirect()->route("model.view", ["modelId" => $modelId]);
    }

    public function modelDelete(Request $request, $modelId) {
        $model = $this->findEditModel($modelId);
        return view("delete", [
            "title" => $model->name,
            "message" => __("model.message.delete"),
            "deleteAction" => __("model.action.delete"),
            "cancelAction" => __("model.action.cancel"),
        ]);
    }

    public function modelDeletePost(Request $request, $modelId) {
        $model = $this->findEditModel($modelId);
        $model->deleted = true;
        $model->save();

        return redirect()->route("user.model.my");
    }

    public function modelCreatePost(Request $request) {
        $data = $this->validateModelData($request);

        $user = auth()->user();

        $model = new Model3D;
        $model->name = $data["name"];
        $model->descr = $data["descr"];
        $model->created_at = Carbon::now();
        $model->created_by = $user->id;
        $model->deleted = false;
        $model->hidden = $data["hidden"];
        $model->width = $data["width"];
        $model->height = $data["height"];
        $model->length = $data["length"];
        $model->save();

        return redirect()->route("model.view", ["modelId" => $model->id]);
    }

    public function models(Request $request) {
        $nameSearch = $request->input("name_search");

        $modelsQuery = Model3D::query()
            ->where("hidden", false)
            ->where("deleted", false);

        if ($nameSearch) {
            $modelsQuery->where("name", "like", "%$nameSearch%");
        }

        $paginator = $modelsQuery->paginate(4)->withQueryString();

        return view("model.list", [
            "paginator" => $paginator,
            "my" => false,
            "nameSearch" => $nameSearch,
        ]);
    }

    public function modelsPost(Request $request) {
        return redirect()->route("model.list", ["name_search" => $request->input("name_search")]);
    }

    public function modelView(Request $request, $modelId) {
        $model = $this->findViewModel($modelId);
        return view("model.view", ["model" => $model]);
    }
}
