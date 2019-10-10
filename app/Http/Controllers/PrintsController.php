<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DTR;
use App\Project;
use App\Employee;
use App\Holidays;
use App\SalaryDeductions;
use App\SalaryDeductionsLogs;

class PrintsController extends Controller
{
    public function project($projectid, $from, $to)
    {

        // return DTR::whereBetween('date', [$from, $to])->get();
        $projectname = Project::where('projectid', $projectid)->pluck('projectname')->first();


        $dtrRecords = DTR::whereBetween('date', [$from, $to])->where('projectid', $projectid)->orderBy('date', 'asc')->get();

        $dtrRecords = $dtrRecords->map(function ($q) {
            if ($q->assignmentz == null) {
                $q->pay = $q->summonz->assignmentz->employeez->pay;
            } else {
                $q->pay = $q->assignmentz->employeez->pay;
            }
            return $q;
        })->values();        // return $dtrRecords;

        return view('printing.byprojectdates')->with('dtrs', $dtrRecords)->with('title', $projectname . ' Project Summary of Attendances')->with('holidates', Holidays::pluck('date'));
    }
    public function employee($employeeid, $from, $to)
    {

        $dtrRecords = DTR::whereBetween('date', [$from, $to])->get()->where('employeeid', $employeeid);

        // return $dtrRecords;
        // $dtrRecords = $dtrRecords->whereHas('assignmentz', function ($q) use ($employeeid) {
        //     $q->where('employeeid', $employeeid);
        // })->orWhereHas('summonz', function ($q) use ($employeeid) {
        //     $q->where('employeeid', $employeeid);
        // })->get();
        $employeename = Employee::where('employeeid', $employeeid)->get()->pluck('full_name')->first() . ' Summary of Attendances ';
        // return $dtrRecords;
        // return $employeename;
        $dtrRecords = $dtrRecords->map(function ($q) {
            if ($q->assignmentz == null) {
                $q->pay = $q->summonz->assignmentz->employeez->pay;
            } else {
                $q->pay = $q->assignmentz->employeez->pay;
            }
            return $q;
        })->values();


        return view('printing.byemployeedates')->with('dtrs', $dtrRecords)->with('title', $employeename);
    }

    public function payroll($projectid, $from, $to)
    {
        $finalPayroll = DTR::whereBetween('date', [$from, $to])->where('projectid', $projectid)->orderBy('date', 'asc')->get();
        $holidates = Holidays::pluck('date');
        $finalPayroll = $finalPayroll->map(function ($q) use ($holidates) {

            if ($q->assignmentz == null) {
                $q->assignmentz = $q->summonz->assignmentz;
            }
            $q->projectName = $q->projectz->projectname;
            $q->employeeName = $q->assignmentz->employee_name;
            $q->skill = $q->assignmentz->employeez->skillz->description;
            $q->basePay = $q->assignmentz->employeez->skillz->salaryrate;
            $q->totalTime = $q->time;
            if ($q->totalTime > 8) {

                $q->overTime = $q->totalTime - 8;
                if ($holidates->contains($q->date)) {
                    $q->time = ($q->totalTime - $q->overTime) * 1.5;
                } else {
                    $q->time = $q->totalTime - $q->overTime;
                }
            } else {
                if ($holidates->contains($q->date)) {
                    $q->overTime = 0;
                    $q->time = $q->totalTime * 1.5;
                } else {
                    $q->overTime = 0;
                    $q->time = $q->totalTime;
                }
            }
            if ($q->overTime > 0) {

                $q->overTimePay = $q->overTime * ($q->basePay / 8) * 1.2;
            } else {
                $q->overTimePay = 0;
            }


            $q->locationFromRate = $q->assignmentz->employeez->locationz->locationrate;
            $q->locationToRate = $q->projectz->locationz->locationrate;
            $deductions = $q->assignmentz->employeez->salarydeductionz;
            $q->locationRate = abs($q->locationFromRate - $q->locationToRate);
            $q->sss = $deductions->where('deductiontypeid', 'sss')->first()['amount'];
            $q->philhealth = $deductions->where('deductiontypeid', 'philhealth')->first()['amount'];
            $q->cashadvance = $deductions->where('deductiontypeid', 'cashadvance')->first()['amount'];
            $q->finalPay = ($q->time * ($q->basePay / 8) + $q->overTimePay) + $q->locationRate;

            return $q->only(['dtr_id', 'date', 'projectName',  'employeeName', 'skill', 'basePay', 'totalTime', 'time', 'overTime', 'overTimePay', 'finalPay', 'locationRate', 'sss', 'philhealth', 'cashadvance']);
        });
        $projectname = $finalPayroll->pluck('projectName')->unique()->first();

        return view('printing.bypayrollproject')->with('dtrs', $finalPayroll)->with('holidates', $holidates)->with('projectname', $projectname);
    }


    public function finalPayroll($projectid, $projectdate)
    {
        // $dateTo = '2019-08-24';
        // $dateFrom = '2019-08-10';
        // $finalPayroll = DTR::whereBetween('date', [$dateFrom, $dateTo])->get();

        $finalPayroll = DTR::where('date', $projectdate)->where('projectid', $projectid)->get();
        // $finalPayroll = DTR::all();
        $holidates = Holidays::pluck('date');


        $finalPayroll = $finalPayroll->map(function ($q) use ($holidates) {

            if ($q->assignmentz == null) {
                $q->assignmentz = $q->summonz->assignmentz;
            }
            $q->projectName = $q->projectz->projectname;
            $q->employeeName = $q->assignmentz->employee_name;
            $q->skill = $q->assignmentz->employeez->skillz->description;
            $q->basePay = $q->assignmentz->employeez->skillz->salaryrate;
            $q->totalTime = $q->time;
            if ($q->totalTime > 8) {

                $q->overTime = $q->totalTime - 8;
                if ($holidates->contains($q->date)) {
                    $q->time = ($q->totalTime - $q->overTime) * 1.5;
                } else {
                    $q->time = $q->totalTime - $q->overTime;
                }
            } else {
                if ($holidates->contains($q->date)) {
                    $q->overTime = 0;
                    $q->time = $q->totalTime * 1.5;
                } else {
                    $q->overTime = 0;
                    $q->time = $q->totalTime;
                }
            }
            if ($q->overTime > 0) {

                $q->overTimePay = $q->overTime * ($q->basePay / 8) * 1.2;
            } else {
                $q->overTimePay = 0;
            }


            $q->locationFromRate = $q->assignmentz->employeez->locationz->locationrate;
            $q->locationToRate = $q->projectz->locationz->locationrate;
            $deductions = $q->assignmentz->employeez->salarydeductionz;
            $q->locationRate = abs($q->locationFromRate - $q->locationToRate);
            $q->sss = $deductions->where('deductiontypeid', 'sss')->first()['amount'];
            $q->philhealth = $deductions->where('deductiontypeid', 'philhealth')->first()['amount'];
            $q->cashadvance = $deductions->where('deductiontypeid', 'cashadvance')->first()['amount'];
            $q->finalPay = ($q->time * ($q->basePay / 8) + $q->overTimePay) + $q->locationRate;
            $q->employeeid = $q->assignmentz->employeeid;
            return $q->only(['dtr_id', 'date', 'projectName', 'employeeid',  'employeeName', 'skill', 'basePay', 'totalTime', 'time', 'overTime', 'overTimePay', 'finalPay', 'locationRate', 'sss', 'philhealth', 'cashadvance']);
        });

        // return $this->singil($finalPayroll);

        $finalPayroll = $finalPayroll->map(function ($q) {
            if (date('D', strtotime($q['date'])) == 'Sat') {
                $q['isSaturday'] = 'true';
            } elseif (date('D', strtotime($q['date'])) == 'Sun') {
                $q['isSunday'] = 'true';
            } else {
                $q['isWeekdays'] = 'true';
            }
            return $q;
        });

        return $finalPayroll;
    }

    public function singil($date)
    {


        $dtr =  DTR::where('date', $date)->get();

        $dtr = $dtr->map(function ($q) {
            if ($q->assignmentz == null) {
                $q->assignmentz = $q->summonz->assignmentz;
            }
            return $q;
        });
        return $dtr =  $dtr->map(function ($q) {
            $q->deductionz =  $q->assignmentz->employeez->salarydeductionz;
            foreach ($q->deductionz as $d) {
                if (SalaryDeductionsLogs::all()->where('sdlogs_date', (date('Y-m-d')))->where('salarydeductionsid', $d->salarydeductionsid)) {
                    ($q->deductionz->diffKeys($d));
                }
            }
            $q->employeeid = $q->assignmentz->employeeid;
            $q->employeename = $q->assignmentz->employeez->full_name;
            return $q->only(['dtr_id', 'deductionz', 'employeename']);
        });


        // return date('W', strtotime($dtr->date));
    }
    public function holiday()
    {
        return Holidays::all();
    }
    public function bayad(Request $request)
    {
        $dedz = ($request->input('ded'));

        foreach ($dedz as $d) {


            $sal = SalaryDeductions::find($d);
            if (date('W', strtotime($sal->date)) == date('W', strtotime(date('Y-m-d')))) {
                return array('type' => 'danger', 'message' => $sal->employeez->full_name . ' Payment for this week already done');
            } else {
                if ($sal->deductiontypeid != 'cashadvance') {
                    $q = SalaryDeductions::find($d);
                    $q->date = date('Y-m-d');
                    $q->save();
                    $p = new SalaryDeductionsLogs(
                        [
                            'salarydeductionsid' => $d,
                            'sdlogs_date' => date('Y-m-d'),
                            'sdlogs_amount' => $sal->amount
                        ]
                    );
                    $p->save();
                } else {
                    $q = SalaryDeductions::find($d);
                    $q->amount = $q->amount - 500;
                    $q->date = date('Y-m-d');
                    $q->save();

                    $q->$p = new SalaryDeductionsLogs([
                        'salarydeductionsid' => $d,
                        'sdlogs_date' => date('Y-m-d'),
                        'sdlogs_amount' => -500
                    ]);

                    $p->save();
                }

                return array('type' => 'success', 'message' => $sal->employeez->full_name . ' payment saved');
            }
            // return date('W', strtotime($dtr->date));


        }
    }
}
