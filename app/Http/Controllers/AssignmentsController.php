<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Employee;
use App\Assignment;
use App\Skill;
use App\Summon;

class AssignmentsController extends Controller
{
    // public function assignview()
    // {
    //     $powerful = Skill::select('skillid')
    //         ->where('description', 'LIKE', '%' . 'Engineer' . '%')
    //         ->orWhere('description', 'LIKE', '%Foreman%')
    //         ->get();

    //     //$employees = Employee::with('assignmentz.projectz')->get();
    //     //WHAT THE FUCK BOTH WORKED SO I FUCKING TIRED MYSELF WITH EAGERLOADING
    //     $employeess = Employee::with('assignmentz');

    //     $employees = $employeess->whereDoesntHave('skillz', function ($q) {
    //         $q->where('description', 'LIKE', '%Engineer%')
    //             ->orwhere('description', 'LIKE', '%Foreman%')
    //             ->orwhere('description', 'LIKE', '%Secretary%');
    //     })->get();

    //     $assignments = Assignment::with('projectz')->where('projectid', $projectid)->get();
    //     $unassignments =

    //         $title = $assignments->pluck('project_name')->first();
    //     // $projects = Project::all();

    //     $assignables = $employeess->orWhereDoesntHave('assignmentz', function ($q) {
    //         $q->where('projectid', '!=', '1');
    //     })->get();



    //     return view('projects.assign.assign')->with('projectid', $projectid)->with('employees', $employees)->with('assignments', $assignments)->with('title', $title)->with('assignables', $assignables);
    // }



    public function index()
    {
        $projects = Project::with('assignmentz')->where('status', 1)->get();
        $employees = Employee::with('assignmentz')->where('active', 1)->get();


        $assId = Assignment::pluck('employeeid')->all();

        $unassignedemployees = $employees->whereNotIn('employeeid', $assId)->values();

        // $unassigned2employees = $employees->whereHas('assignmentz', function ($q) {
        //     $q->where('projectid', null);
        // })->get();

        $unassigned2employees =  $employees->filter(function ($q) {
            return ($q->assignmentz['projectid'] == null);
        })->values();



        $unassignedAll = $unassigned2employees->merge($unassignedemployees);

        $employeesTiongson = (Employee::where('lname', 'Tiongson')->get());

        $nakuha = $employeesTiongson->filter(function ($q) {
            return $q->employeeid == 6;
        });

        return (($nakuha)->values()->flatten());


        // return gettype(array(
        //     "json" => "format"
        // ));


        // return array(

        //         "object" => "try"

        // );

        // return $unassignedAll;
        // return $unassignedAll;

        // return view('projects.assign.assign')->with('projects', $projects)->with('employees', $unassignedAll);
    }

    public function assignthatbitch(Request $request)
    {
        $project = $request->input('project');
        $employees = $request->input('employees');

        foreach ($employees as $emp) {
            $assignment = Assignment::where('employeeid', '=', $emp)->first();

            if ($assignment == null) {
                $ass = new Assignment([
                    'employeeid' => $emp,
                    'projectid' => $project,
                    'date' => date("Y-m-d"),
                    'active' => 1
                ]);
                $ass->save();
            } else {
                $assignment->projectid = $project;
                $assignment->date = date('Y-m-d');
                $assignment->save();
            }
        }


        $coll = array();

        foreach ($employees as $e) {
            $name = Employee::find($e);


            array_push($coll, $name->full_name);
        }
        $xixi = implode(" | ", $coll);
        return response($coll);

        // return response($request->all());
        // return response()->json();
        // return response($request->all());
    }

    public function try()
    {
        $assignments = Assignment::where('employeeid', '=', 1)->first();
        $assignments->projectid = null;
        $assignments->save();

        return $assignments;
    }

    public function disassignthatbitch(Request $request)
    {
        $employees = $request->input('disassign');

        foreach ($employees as $emp) {
            $assignment = Assignment::find($emp);
            $assignment->projectid = null;
            $assignment->date = date('Y-m-d');
            $assignment->save();
        };

        $coll = array();

        foreach ($employees as $assignmentid) {

            $pe = Assignment::find($assignmentid);
            // $pe->employee_name;
            array_push($coll, $pe->employee_name);
        }


        $xixi = implode(' | ', $coll);

        return redirect()->back()->with('success', $xixi . ' Unassigned');
    }


    public function feeder($ano)
    {
        if ($ano == 'employees') {
            $assId = Assignment::pluck('employeeid')->all();

            $employees = Employee::whereNotIn('employeeid', $assId)->get();
            return response()->json($employees);
        } else { }
    }


    public function assign(Request $request, $projectid)
    {
        $employees = $request->input(' assign ');


        if (!empty($employees)) {

            foreach ($employees as $emp) {
                $assignmentid = Assignment::all()->where(' employeeid ', $emp)->first();
                // $assignmentid = $assignmentid->assignmentid;
                if ($assignmentid == null) {

                    $assignmentid = 0;


                    $assignment = new Assignment([
                        ' employeeid ' => $emp,
                        ' date ' => date("Y-m-d"),
                        ' projectid ' => $projectid,

                    ]);

                    $assignment->save();
                } else {
                    $upd = Assignment::find($assignmentid);


                    $upd->projectid = $projectid;
                    $upd->date = date("Y-m-d");


                    $upd->save();
                }
            }
            return redirect()->back()->with(' success ', "Employee/s assigned");
        } else {
            return redirect()->back()->with(' error ', "No employee assigned");
        }




        // $assignments = $request->input(' assign ');
        // if (!empty($assignments)) {
        //     foreach ($assignments as $ass) {
        //         $assid = Assignment::all()->where(' employeeid ', $ass)->first();
        //         $assid = $assid->assignmentid;
        //         $assignmentupdated = Assignment::find($assid);
        //         $update = [
        //             ' employeeid ' => $ass,
        //             ' projectid ' => $projectid,
        //             ' date ' => $request->get(' date ')
        //         ];
        //         $assignmentupdated->update($update);
        //     }
        //     return redirect()->back()->with(' success ', "Employee/s has been assigned");
        // } else {
        //     return redirect()->back()->with(' error ', "No Employee to be assigned");
        // }
    }

    public function assignmenthistoryview($projectid, $employeeid)
    {
        // $title = Employee::find($employeeid);
        // $title = $title->lname . ", " . $title->fname;
        // $assignments = Assignment::where('employ eeid', $employeeid)->get();

        // return view(' pro j ects.a s sign.showassign ')->with('assig nments', $assignments)->with('pro jectid', $projectid)->with('title', $title);
    }

    // public function engineerview()
    // {
    //     // $powerful = Skill::where(' description ', ' LIKE ', ' % '.' Engineer '.' % ')->orWere(' description ', ' LIKE ', ' % '.' foreman '.' % ')->get();
    //     $powerful = Skill::select(' skillid ')
    //     ->where(' description ', ' LIKE ', ' % '.' Engineer '.' % ')
    //     ->orWhere(' description ', ' LIKE ', ' % Foreman % ')
    //     ->orwhere(' description ', ' LIKE ', ' % Secretary % ')
    //     ->get();


    //     $empcollection = collect([]);
    //     $employees = Employee::with(' assignmentz . projectz')->get();


    //     foreach($employees as $employee)
    //     {
    //         foreach($powerful as $skill)
    //         {
    //             if($employee->skillid == $skill->skillid)
    //             {
    //                 $empcollection->push($employee);

    //             }
    //         }
    //     }



    //     $latest = collect([]);
    //     $latest1=collect([]);

    //     foreach($empcollection as $empcollection)
    //     {
    //         $latest->push($empcollection);
    //         $i=0;
    //         $limit=count($empcollection->assignmentz)-1;

    //         foreach($empcollection->assignmentz as $assignmentz)
    //         {
    //             if($i==$limit)
    //             {
    //                 $latest1->push($assignmentz->projectz->projectname);
    //             }
    //             $i++;

    //         }
    //     }


    //     return $latest1;



    // }



}
