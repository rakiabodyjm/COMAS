<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTR;
use App\Employee;
use App\Project;
use App\Holidays;

class PayrollsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $inputProjectID = 1;

        $inputDate = '2019-08-10';


        $dtr = DTR::without(['assignmentz', 'employeez'])->get();

        $projectNames = Project::where('status', 1)->get();

        $dtr = DTR::whereHas('projectz', function ($d) {
            $d->where('status', 1);
        })->get();

        $projectNames = $dtr->map(function ($d) {
            return $d->only(['projectid', 'project_name']);
        })->where('project_name', '<>', 'No Project')->unique('project_name')->values();

        $projectNames = $dtr->map(function ($q) {
            $project = array();

            $project = array(
                'projectid' => $q->projectz['projectid'],
                'projectname' => $q->projectz['projectname']
            );

            return $project;
        })->unique('projectname')->values();



        $projectDates = $dtr->map(function ($d) {
            return $d->only(['projectid', 'date']);
        })->where('project_name', '<>', 'No Project')->values()->sortBy('date')->values();

        $holidates = Holidays::pluck('date');

        // return $this->create2('1', '2019-08-15');
        return view('payroll.index')->with('projects', $projectNames)->with('projectDates', $projectDates)->with('holidates', $holidates);
    }

    public function create1($inputProjectID)
    {
        $dtr = DTR::whereHas('projectz', function ($d) {
            $d->where('status', 1);
        })->get();

        $dtrbyProjectID = $dtr->map->only(['projectid', 'project_name', 'assignmentid', 'summonid', 'time', 'date'])->where('projectid', $inputProjectID)->unique('date')->values();

        $dtrbyProjectIDnew = $dtrbyProjectID->map(function ($item, $key) {
            $collection = array();

            $date = array('dateString' => date('D', strtotime($item['date'])) . ' | ' .  date('F j, Y', strtotime($item['date'])), 'date' => $item['date'], 'projectid' => $item['projectid'], 'projectname' => $item['project_name']);

            return $date;
        })->values();

        return $dtrbyProjectIDnew->sortByDesc('date')->values();
    }

    public function finalPayroll($projectid, $date)
    {
        $dateTo = '2019-08-23';
        $dateFrom = '2019-08-10';
        $finalPayroll = DTR::whereBetween('date', [$dateFrom, $dateTo])->get();

        // $finalPayroll = DTR::where('dtr_id', $dtrid)->get();

        $finalPayroll = $finalPayroll->map(function ($q) {
            if ($q->assignmentz != null) {
                $q->projectname = $q->projectz->projectname;
                $q->employeename = $q->assignmentz->employee_name;
                $q->basepay = $q->assignmentz->employeez->skillz->salaryrate;
                $q->time = $q->time;
                $q->locationfromrate = $q->assignmentz->employeez->locationz->locationrate;
                $q->locationtorate = $q->projectz->locationz->locationrate;
                $deductions = $q->assignmentz->employeez->salarydeductionz;

                $q->sss = $deductions->where('deductiontypeid', 'sss')->first()['amount'];
                $q->philhealth = $deductions->where('deductiontypeid', 'philhealth')->first()['amount'];
                $q->cashadvance = $deductions->where('deductiontypeid', 'cashadvance')->first()['amount'];
                return $q->only(['dtr_id', 'date', 'projectname', 'employeename', 'basepay', 'time', 'locationfromrate', 'locationtorate', 'sss', 'philhealth', 'cashadvance']);
            } else {
                $q->assignmentz = $q->summonz->assignmentz;
                $q->projectname = $q->projectz->projectname;
                $q->employeename = $q->assignmentz->employee_name;
                $q->basepay = $q->assignmentz->employeez->skillz->salaryrate;
                $q->time = $q->time;
                $q->locationfromrate = $q->assignmentz->employeez->locationz->locationrate;
                $q->locationtorate = $q->projectz->locationz->locationrate;
                $deductions = $q->assignmentz->employeez->salarydeductionz;
                $q->sss = $deductions->where('deductiontypeid', 'sss')->first()['amount'];
                $q->philhealth = $deductions->where('deductiontypeid', 'philhealth')->first()['amount'];
                $q->cashadvance = $deductions->where('deductiontypeid', 'cashadvance')->first()['amount'];

                return $q->only(['dtr_id', 'date', 'projectname', 'employeename', 'basepay', 'time', 'locationfromrate', 'locationtorate', 'sss', 'philhealth', 'cashadvance']);
            }
        });

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
        $finalPayrolldeducted = $finalPayroll->map(function ($q) {
            if ($q['isSaturday'] == 'true') {
                if ($q['cashadvance'] != null) {
                    $q['day'] = Date('d', strtotime($q['date']));
                }
            } elseif ($q['isSunday'] == 'true') {
                $q['day'] = Date('d', strtotime($q['date']));
            } else { }
        });


        //HOLY CHECKERS
        // return date('D', strtotime('2019-08-24'));
        // return (date('N', strtotime('2019-08-25')) >= 6);

        return ($finalPayroll);
        // $finalPayroll->map(function ($q) { });
    }

    public function create2($projectID, $projectDate)
    {

        $holidates = Holidays::all()->pluck('date');



        $dtr = DTR::where('projectid', $projectID)->where('date', $projectDate)->get();

        ($dtrwithPay = $dtr->map(function ($d) {
            return $d->only(['dtr_id', 'time', 'date', 'assignmentz', 'summonz']);
        }));

        // return $dtrwithPay;
        $finalPayroll = collect();
        foreach ($dtrwithPay as $pay) {
            if ($pay['assignmentz'] != null) {
                $dtrName = $pay['assignmentz']->employee_name;
                $dtrRate = ($pay['assignmentz']->employeez->pay) / 8;
                $dtrTime = $pay['time'];
                $dtrDate = $pay['date'];

                if ($pay['time'] > 8) {
                    if ($holidates->contains($dtrDate)) {
                        $dtrPay = ($dtrRate * 8) * 1.3;
                    } else {
                        $dtrPay = ($dtrRate * 8) * 1.2;
                    }
                } else {
                    if ($holidates->contains($dtrDate)) {
                        $dtrPay = $dtrRate * 1.30 * $dtrTime;
                    } else {
                        $dtrPay = $dtrRate * $dtrTime;
                    }
                }


                $pay['finalPay'] = $dtrPay;
                $pay['full_name'] = $dtrName;
                $finalPayroll->push($pay);
                // $dtrwithPay->push($pay);

            } else {
                $dtrName = $pay['summonz']->assignmentz->employee_name;
                $dtrRate = ($pay['summonz']->assignmentz->employeez->pay) / 8;
                $dtrTime = $pay['time'];
                $dtrDate = $pay['date'];

                //IF OVERTIME COMPUTATION
                if ($pay['time'] > 8) {
                    if ($holidates->contains($dtrDate)) {
                        $dtrPay = $dtrRate * 1.30 * $dtrTime;
                    } else {
                        $dtrPay = $dtrRate * 1.25 * $dtrTime;
                    }
                } else {
                    if ($holidates->contains($dtrDate)) {
                        $dtrPay = $dtrRate * 1.30 * $dtrTime;
                    } else {
                        $dtrPay = $dtrRate * $dtrTime;
                    }
                }

                //IF HOLIDAY COMPUTATION
                // if ($holidates->contains($dtrDate)) {
                //     $dtrPay = $dtrRate * $dtrTime * 1.5;
                // } else {
                //     $dtrPay = $dtrRate * $dtrTime;
                // }

                $pay['finalPay'] = $dtrPay;
                $pay['full_name'] = $dtrName;
                // $dtrwithPay->push($pay);

                $finalPayroll->push($pay);
            }
        }
        $finalPayroll = $finalPayroll->map(function ($item, $key) {
            return collect($item)->except(['summonz', 'assignmentz']);
        });

        return $finalPayroll;
    }


    public function create(Request $request, $inputProjectID, $inputDate)
    {

        if ($inputDate != 'nothing') {
            // $dtrbyProjectIDandDate = $dtrbyProjectID->where('date', $inputDate);
            return response()->json($this->create2($inputProjectID, $inputDate));
        } else {
            return response()->json($this->create1($inputProjectID));
            // return response()->json($dtrbyProjectIDnew);
        }
    }

    public function holidays($function, $date)
    {
        if ($function == 'delete') {
            $holiday = Holidays::firstOrFail()->where('date', $date);
            $holiday->delete();
        } else {

            $hol = Holidays::firstOrCreate(['date' => $date], ['date' => $date]);
            return response()->json($hol);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
