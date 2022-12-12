<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;

use Carbon\Carbon;

class UserController extends Controller {

    public function projects(Request $request) {
        $user = auth()->user();
        $projectsQuery = Project::query()
            ->where("created_by", $user->id)
            ->where("deleted", false);

        $paginator = $projectsQuery->paginate(4);

        return view("user.project.list", ["paginator" => $paginator]);
    }

    public function projectCreate(Request $request) {
        return view("user.project.create");
    }

    protected function validateProjectData(Request $request) {
        $data = $request->validate([
            "name" => "required|min:4|max:50",
            "descr" => "max:65535",
        ]);

        if (!$data["descr"]) {
            $data["descr"] = "";
        }

        return $data;
    }

    public function projectCreatePost(Request $request) {
        $data = $this->validataProjectData($request);

        $project = new Project;
        $project->name = $data["name"];
        $project->descr = $data["descr"];
        $project->created_at = Carbon::now();
        $project->created_by = auth()->user()->id;
        $project->deleted = false;
        $project->hidden = true;
        $project->save();

        return redirect()->route("project.view", ["projectId" => $project->id]);
    }

    protected function findEditProject(Request $request, $projectId) {
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

    public function projectEdit(Request $request, $projectId) {
        $project = $this->findEditProject($request, $projectId);
        return view("user.project.edit", ["project" => $project]);
    }

    public function projectEditPost(Request $request, $projectId) {
        $project = $this->findEditProject($request, $projectId);
        $data = $this->validateProjectData($request);

        $project->name = $data["name"];
        $project->descr = $data["descr"];
        $project->save();

        return redirect()->route("project.view", ["projectId" => $projectId]);
    }
}
