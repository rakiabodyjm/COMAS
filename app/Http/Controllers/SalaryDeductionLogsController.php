<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalaryDeductions;
use App\SalaryDeductionsLogs;
use App\Rules\ValidEmployee;
use App\Employee;

class SalaryDeductionLogsController extends Controller
{
    public function show($which, $id)
    {


        $title = strtoupper($which);

        $name = SalaryDeductions::find($id)->employeez->full_name;

        // $deduction = SalaryDeductions::all()->where('employeeid', $id)->where('deductiontypeid', $which)->first();

        $logs = SalaryDeductionsLogs::all()->where('salarydeductionsid', $id)->values();

        // return $logs;


        $balance = $logs->sum('amount');
        return view('employees.deductions.deductionlogs')->with('title', $title)->with('name', $name)->with('logs', $logs)->with('which', $which)->with('id', $id)->with('where', $which);
    }
    public function store(Request $request, $which, $id)
    {
        $deductionlogs = SalaryDeductionsLogs::all();


        $request->validate([
            // 'ename' => ['required', new ValidEmployee],
            'amount' => 'required|numeric',
            'date' => 'required'
        ]);


        switch ($request->input('loan')) {

            case 'pay':
                $amount = $request->get('amount');
                $amount = $amount;

                break;
            case 'loan':
                $amount = $request->get('amount');
                $amount = -($amount);
                break;
        }

        // return ($request->input('loan')) . ' ' . $amount;

        $deduction = SalaryDeductions::all()->where('employeeid', $id)->where('deductiontypeid', $which)->first();

        $deduction->amount = ($deduction->amount) - $amount;
        $deduction->save();

        // return 'putangina salarydeductionid ' . $id . $which . $amount;

        $deductionlogs = new SalaryDeductionsLogs([
            'salarydeductionsid' => $deduction->salarydeductionsid,
            'sdlogs_amount' => $amount * -1,
            'sdlogs_date' => $request->get('date'),

        ]);
        $deductionlogs->save();




        return redirect()->back()->with('success', strtoupper($which) . ' has been added');
    }
}
