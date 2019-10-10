<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Location;
use App\Assignment;
use App\DTR;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $locations = Location::all();
        $projects = Project::all();

        return view('projects.all')->with('projects', $projects)->with('locations', $locations);
    }

    public function index()
    {


        $locations = Location::all();

        $projects = Project::all()->where('status', '1');

        $peps = DTR::all();


        return view('projects.index')->with('projects', $projects)->with('locations', $locations)->with('peps', $peps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'projectname' => 'required',
            'client' => 'required'
        ]);

        $project = new Project([
            'projectname' => $request->get('projectname'),
            'locationid' => $request->get('location'),
            'client' => $request->get('client'),
            'status' => 1


        ]);

        $project->save();

        return redirect('/projects')->with('success', 'project has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projects = Project::all()->where('status', '1');

        $assignments = Assignment::orderBy('assignmentid', 'desc')->get();

        $assignments = $assignments->where('active', 1)->where('projectid', $id);

        $title = Project::where('projectid', $id)->first()->projectname;


        $dtr = DTR::where('projectid', $id)->distinct('date')->orderBy('date', 'desc')->pluck('date');

        // return $title;
        return view('projects.show')->with('projectid', $id)->with('assignments', $assignments)->with('title', $title)->with('dtr', $dtr)->with('projects', $projects);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $locations = Location::all();




        return view('projects.edit')->with('project', $project)->with('locations', $locations)->with('projectsid', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectsid)
    {
        $ass =  Assignment::where('projectid', $projectsid)->get();
        $ass = $ass->map->only('assignmentid')->values();
        $ass = $ass->pluck('assignmentid');

        $request->validate([
            'projectname' => 'required',
            'client' => 'required'

        ]);

        $project = Project::find($projectsid);

        $project->projectname = $request->get('projectname');
        $project->locationid = $request->get('location');
        $project->client = $request->get('client');

        $update = $request->get('status');

        $deleted = "";
        if ($update == 0) {
            foreach ($ass as $a) {
                $ass = Assignment::find($a);
                $ass->projectid = null;
                $ass->save();

                $deleted .= $ass->employee_name . ' | ';
            }
            $project->status = 0;
        } else {
            $project->status = 1;
        }
        // $project->status = $request->get('status');

        $project->save();




        // return 'it worked?';
        return redirect('/projects')->with('success', 'Project Information has been edited with Assignments: ' . $deleted);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
