<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Skill;
use App\DTR;
use App\Assignment;
use App\Summon;
use App\Location;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $employees = Employee::all();
        $employees = $employees->sortBy('full_name');

        $skills = Skill::all()->where('active', 1);

        $assignments = Assignment::all();
        return view('employees.all')->with('employees', $employees)->with('skills', $skills)->with('ass', $assignments)->with('locations', Location::all());
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
            'lastname' => 'required',
            'firstname' => 'required',
            'address' => 'required',
            'phoneno' => 'required|numeric'

        ]);

        $employee = new Employee([
            'lname' => $request->get('lastname'),
            'fname' => $request->get('firstname'),
            'address' => $request->get('address'),
            'phoneno' => $request->get('phoneno'),
            'skillid' => $request->get('skill'),
            'locationid' => $request->get('location')
        ]);

        $employee->save();

        return redirect('/employees')->with('success', 'Employee has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        $assignment = Assignment::where('employeeid', $employee->employeeid)->get();

        if (count($assignment) > 0) {

            $assignmentid = $assignment->first()->assignmentid;

            $summonids = array();
            $dtrs = collect();

            $summons = Summon::where('assignmentid', $assignmentid)->get();


            $dtrs->push(DTR::with('projectz')->where('assignmentid', $assignmentid)->get());

            // $dtrs->map(function($q)
            // {
            //     if($q->assignmentz==null)
            //     {
            //         $q->assignmentz = $q->summonz->assignmentz;
            //     }
            //     $q->finalPay = $q->assignmentz->
            // return $q;
            // })

            foreach ($summons as $summ) {

                // $summonid = $;


                $try = DTR::where('summonid', $summ->summonid)->get();
                if (count($try) > 0) {
                    $dtrs->push(DTR::with('projectz')->where('summonid', $summ->summonid)->get());
                }
            }
            $dtrs = $dtrs->flatten()->sortByDesc('date');
        } else {
            $dtrs = collect([]);
        }

        $dtrs = $dtrs->map(function ($q) {
            if ($q->assignmentz == null) {
                $q->pay = $q->summonz->assignmentz->employeez->pay;
            } else {
                $q->pay = $q->assignmentz->employeez->pay;
            }
            return $q;
        })->values();
        // return $dtrs->values();
        // return dd(DTR::with('projectz')->get());

        // return $dtrs;
        return view('employees.show')->with('employee', $employee)->with('dtrs', $dtrs)->with('assignment', $assignment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $skills = Skill::all()->where('active', 1);
        $locations = Location::all();

        $assignmentofthisemployee = Assignment::where('employeeid', $id)->get();
        return view('employees.edit')->with('employee', $employee)->with('skills', $skills)->with('assignment', $assignmentofthisemployee)->with('locations', $locations);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'address' => 'required',
            'phoneno' => 'required|numeric',
        ]);

        $employee = Employee::find($id);

        $employee->lname = $request->get('lastname');
        $employee->fname = $request->get('firstname');
        $employee->address = $request->get('address');
        $employee->phoneno = $request->get('phoneno');
        $employee->skillid = $request->get('skill');
        $employee->active = $request->get('active');
        $employee->locationid = $request->get('location');

        $employee->save();

        return redirect('/employees')->with('success', 'Employee Information has been edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { }
    public function all()
    {
        $skills = Skill::all();
        $employees = Employee::all();

        return view('employees.all')->with('skills', $skills)->with('employees', $employees);
    }
}
