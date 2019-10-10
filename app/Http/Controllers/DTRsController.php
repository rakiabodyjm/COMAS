<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\DTR;



class DTRsController extends Controller
{
    public function index($projectsid)
    {

        $project = Project::select('projectid', 'projectname')->where('active', 1)->get();

        return $project;

        $assignments = Assignment::where('projectid', $projectsid)->get();

        $DTR = DTR::all();




        $date = date('F j, Y');
        return view('projects.attendance.attendanceview')->with('assignments', $assignments)->with('date', $date);
    }
}
