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
}
