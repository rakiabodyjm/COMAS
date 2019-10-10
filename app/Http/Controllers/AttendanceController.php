<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Employee;
use App\Assignment;
use App\Summon;
use App\DTR;

class AttendanceController extends Controller
{
    public function attendance($projectid, $date)
    {


        $projects = Project::all()->where('status', '1');

        $dateString = date('F j, Y', strtotime($date));

        $unassignments = $this->differentiator($projectid, $date, 'assignments');
        $dtrs = $this->differentiator($projectid, $date, 'dtrs');
        $alldtr = DTR::all();
        $summoned = Summon::all()->where('dtrz', null)->where('projectid', $projectid)->where('date', $date);

        $summonids = array();
        $unasids = array();
        $dtrids = array();

        foreach ($unassignments as $unas) {
            array_push($unasids, $unas->assignmentid);
        }

        foreach ($summoned as $summ) {
            array_push($summonids, $summ->assignmentid);
        }

        foreach ($dtrs as $dtr) {
            if (!DTR::find($dtr->dtr_id)) {
                array_push($dtrids, $dtr->assignmentid);
            }
        }
        $merged = array_merge($summonids, $unasids, $dtrids);
        $assignments = Assignment::whereNotIn('assignmentid', $merged)->get();


        $projectname = Project::where('projectid', $projectid)->get();
        $projectname = $projectname->pluck('projectname')->first();

        $summoned = $summoned->values();
        // return $summoned;
        return view('projects.attendance.attendanceview')->with('date', $date)->with('assignments', $unassignments)->with('projectid', $projectid)->with('dtrs', $dtrs)->with('dateString', $dateString)->with('summoned', $summoned)->with('summon', $assignments)->with('projectname', $projectname)->with('projects', $projects);
    }

    public function differentiator($projectid, $date, $which)
    {
        $dtrs = DTR::with(['summonz.assignmentz', 'assignmentz'])->where('projectid', '=', $projectid)->where('date', $date)->get();
        $summon = Summon::where('projectid', '=', $projectid)->where('date', $date)->get();

        $assignments = Assignment::with('employeez')->where('projectid', $projectid)->where('date', '<=', $date)->get();

        $assignmentids = array();
        $dtrids = array();

        $unassignments = collect();

        foreach ($assignments as $ass) {
            array_push($assignmentids, $ass->assignmentid);
        }
        foreach ($dtrs as $dt) {
            array_push($dtrids, $dt->assignmentid);
        }

        $unassigned = array_diff($assignmentids, $dtrids);

        foreach ($unassigned as $un) {
            $we = $assignments->where('assignmentid', $un);
            $unassignments->push($we);
        }
        $unassignments = $unassignments->flatten();

        if ($which == 'assignments') {
            return $unassignments;
        } elseif ($which == 'dtrs') {
            return $dtrs;
        }
    }


    public function post(Request $request, $projectid, $date)
    {
        $assignments = $this->differentiator($projectid, $date, 'assignments');
        $dtrs = $this->differentiator($projectid, $date, 'dtrs');
        $summon = Summon::where('projectid', $projectid)->where('date', $date)->get();

        $assid = $assignments->pluck('assignmentid');

        $empties = array();
        $repeater = array();
        $errorFound = null;

        // return $summon;
        foreach ($summon as $summ) {

            // return $summon;
            $summonercustom = $request->input('summcustom' . $summ->summonid);

            $summoner = $request->input('summonid:' . $summ->summonid);
            $time = null;


            // return $request->all();

            if ($summonercustom != null) {
                $time = $summonercustom;
            } else if ($summoner != null) {
                $time = $summoner;
            } else {
                $summoness = $summon->where('summonid', $summ->summonid)->first();
                $summoness = $summoness->employee_name;
                array_push($empties, $summoness);
            }

            if ($time !== null) {
                $dtr = new DTR([
                    'assignmentid' => null,
                    'projectid' => $projectid,
                    'summonid' => $summ->summonid,
                    'time' => $time,
                    'date' => $date
                ]);
                $dtr->save();
            }
        }



        foreach ($assid as $id) {
            $attendance = $request->input($id);
            $attendancecustom = $request->input('asscustom' . $id);
            $time = null;

            //77 AND 79
            if ($attendance != null) {
                $time = $attendance;
            } else if ($attendancecustom != null) {
                $time = $attendancecustom;
            } else {
                $asses = $assignments->where('assignmentid', $id)->first();
                $asses = $asses->employeez->full_name;
                array_push($empties, $asses);
            }


            if ($time !== null) {
                $dtr = new DTR([
                    'assignmentid' => $id,
                    'projectid' => $projectid,
                    'summonid' => null,
                    'time' => $time,
                    'date' => $date
                ]);
                $dtr->save();
            }
        }

        if (!empty($empties)) {
            $empties = implode(" | ", $empties);
            return redirect()->back()->with('error', 'ATTENDANCE FOR | ' . strtoupper($empties) . ' | MISSING');
        } else {
            return redirect()->back()->with('success', 'ATTENDANCES SAVED');
        }
    }

    public function delete(Request $request, $projectid, $date, $summonid)
    {
        $weh = $request->all();


        $summon = Summon::find($summonid);
        $summon->delete();

        $response = array('success' => $summon->employee_name . ' deleted');

        // $response = $summon->employee_name . 'Deleted ';
        return $response;

        // return redirect()->back()->session()->flash('success', 'Success');
    }

    public function DTRdelete(Request $request, $projectid, $date, $dtrid)
    {
        $weh = $request->all();


        $dtr = DTR::find($dtrid);
        $dtr->delete();

        $response = array('success' => $dtr->assignmentz->employee_name . ' deleted');

        // $response = $summon->employee_name . 'Deleted ';
        return $response;

        // return redirect()->back()->session()->flash('success', 'Success');
    }


    public function summon(Request $request, $projectid, $date)
    {
        $input = $request->input('summon');
        if (!empty($input)) {
            foreach ($input as $i) {
                $summon = new Summon([
                    'assignmentid' => $i,
                    'projectid' => $projectid,
                    'date' => $date,
                ]);
                $summon->save();
            }
            return redirect()->back()->with('success', 'Summon has been made');
        } else {
            return redirect()->back()->with('error', 'Summon is empty');
        }

        return $summon;
    }


    public function update(Request $request, $projectid, $date)
    {

        $incoming = $request->all();
        $incomingKeys = array_keys(array_except($incoming, '_token'));
        $incomingValues = array_values(array_except($incoming, '_token'));



        if (!empty($incoming)) {
            foreach ($incomingKeys as $keys) {
                if ($keys != null) {
                    $dtrid = str_replace('custom', '', $keys);
                    $dtr = DTR::find($dtrid);
                    if (!empty($dtr)) {

                        $time = $incoming[$keys];

                        $dtr->time = $time;
                        $dtr->save();
                    }
                }
            }
        } else {
            return redirect()->back()->with('success', 'NO UPDATE HAS BEEN MADE');
        }



        return redirect()->back()->with('success', 'ATTENDANCES UPDATED');
    }
}
