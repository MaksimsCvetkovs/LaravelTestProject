<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;

use Carbon\Carbon;

class UserController extends Controller {

    public function projects(Request $request) {
        $user = auth()->user();
        $projectsQuery = Project::where("created_by", $user->id);

        $paginator = $projectsQuery->paginate(10);

        return view("user.project-list", ["paginator" => $paginator]);
    }

    public function projectCreate(Request $request) {
        //dd($request);
        return view("user.project-create");
    }

    public function projectCreatePost(Request $request) {
        $data = $request->validate([
            "name" => "required|min:4|max:25",
            "descr" => "max:65535",
        ]);

        if (!$data["descr"]) {
            $data["descr"] = "";
        }

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
}
