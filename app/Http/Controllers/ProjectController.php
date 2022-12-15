<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Model3D;

use Carbon\Carbon;

class ProjectController extends Controller {

    public static function findEditProject($projectId) {
        $project = Project::findOrFail($projectId);

        if ($project->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if (!$user || !$project->canEdit($user)) {
            abort(404);
        }

        return $project;
    }

    public static function findViewProject($projectId) {
        $project = Project::findOrFail($projectId);

        if ($project->deleted) {
            abort(404);
        }

        $user = auth()->user();

        if ($project->hidden && $user && !$project->canEdit($user)) {
            abort(404);
        }

        return $project;
    }

    public static function validateProjectData(Request $request) {
        $data = $request->validate([
            "name" => "required|min:4|max:50",
            "descr" => "max:65535",
        ]);

        if (!$data["descr"]) {
            $data["descr"] = "";
        }

        $data["hidden"] = $request->boolean("hidden");

        return $data;
    }

    public function projectsMy(Request $request) {
        $nameSearch = $request->input("name_search");

        $user = auth()->user();

        $projectsQuery = Project::query()
            ->withCount("models")
            ->where("created_by", $user->id)
            ->where("deleted", false);

        if ($nameSearch) {
            $projectsQuery->where("name", "like", "%$nameSearch%");
        }

        $paginator = $projectsQuery->paginate(4)->withQueryString();

        return view("project.list", [
            "paginator" => $paginator,
            "my" => true,
            "nameSearch" => $nameSearch,
        ]);
    }

    public function projectsMyPost(Request $request) {
         return redirect()->route("user.model.my", ["name_search" => $request->input("name_search")]);
    }

    public function projectCreate(Request $request) {
        return view("user.project.create");
    }

    public function projectCreatePost(Request $request) {
        $data = $this->validateProjectData($request);

        $project = new Project;
        $project->name = $data["name"];
        $project->descr = $data["descr"];
        $project->created_at = Carbon::now();
        $project->created_by = auth()->user()->id;
        $project->deleted = false;
        $project->hidden = $data["hidden"];
        $project->save();

        return redirect()->route("project.view", ["projectId" => $project->id]);
    }

    public function projectEdit(Request $request, $projectId) {
        $project = $this->findEditProject($projectId);

        $paginator = $project->models()->paginate(6);

        return view("user.project.edit", [
            "project" => $project,
            "paginator" => $paginator,
        ]);
    }

    public function projectEditPost(Request $request, $projectId) {
        $project = $this->findEditProject($projectId);
        $data = $this->validateProjectData($request);

        $project->name = $data["name"];
        $project->descr = $data["descr"];
        $project->hidden = $data["hidden"];
        $project->save();

        return redirect()->route("project.view", ["projectId" => $projectId]);
    }

    public function projectDelete(Request $request, $projectId) {
        $project = $this->findEditProject($projectId);

        return view("delete", [
            "title" => $project->name,
            "message" => __("project.message.delete"),
            "deleteAction" => __("project.action.delete"),
            "cancelAction" => __("project.action.cancel"),
        ]);
    }

    public function projectDeletePost(Request $request, $projectId) {
        $project = $this->findEditProject($projectId);
        $project->deleted = true;
        $project->save();

        return redirect()->route("user.project.my");
    }

    public function projectModelDelete(Request $request, $projectId, $modelId) {
        $project = $this->findEditProject($projectId);

        return view("delete", [
            "title" => $project->name,
            "message" => __("project.message.model-delete"),
            "deleteAction" => __("project.action.model-delete"),
            "cancelAction" => __("project.action.model-cancel"),
        ]);
    }

    public function projectModelDeletePost(Request $request, $projectId, $modelId) {
        $project = $this->findEditProject($projectId);

        $project->models()->detach($modelId);

        return redirect()->route("user.project.edit", ["projectId" => $projectId]);
    }

    public function projectModelAddList(Request $request, $projectId) {
        $project = $this->findEditProject($projectId);

        $user = auth()->user();

        $modelsQuery = Model3D::query()
            ->where("deleted", false)
            ->where(function ($query) use ($user) {
                $query->where("hidden", false)
                    ->orWhere("created_by", $user->id);
            })
            ->whereDoesntHave("projects", function ($query) use ($project) {
                $query->where("id", $project->id);
            });

        $paginator = $modelsQuery->paginate(6);

        return view("user.project.model-add-list", [
            "project" => $project,
            "paginator" => $paginator,
        ]);
    }

    public function projectModelAdd(Request $request, $projectId, $modelId) {
        $project = $this->findEditProject($projectId);
        $model = Model3DController::findViewModel($modelId);

        $project->models()->attach($model->id);

        return redirect()->route("user.project.edit", ["projectId" => $projectId]);
    }

    public function projects(Request $request) {
        $nameSearch = $request->input("name_search");

        $projectsQuery = Project::query()
            ->withCount("models")
            ->whereHas("models")
            ->where("hidden", false)
            ->where("deleted", false);

        if ($nameSearch) {
            $projectsQuery->where("name", "like", "%$nameSearch%");
        }

        $paginator = $projectsQuery->paginate(4)->withQueryString();

        return view("project.list", [
            "paginator" => $paginator,
            "my" => false,
            "nameSearch" => $nameSearch,
        ]);
    }

    public function projectsPost(Request $request) {
        return redirect()->route("project.list", ["name_search" => $request->input("name_search")]);
    }

    public function projectView(Request $request, $projectId) {
        $project = $this->findViewProject($projectId);

        $paginator = $project->models()->paginate(6);

        return view("project.view", [
            "project" => $project,
            "paginator" => $paginator,
        ]);
    }
}
