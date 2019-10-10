<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalaryDeductions;
use App\Employee;
use App\Rules\ValidEmployee;
use function GuzzleHttp\Promise\all;

class SalaryDeductionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($which)
    {

        $salarydeductions = SalaryDeductions::all()->where('deductiontypeid', $which);


        $salarydeductionz = $salarydeductions->unique('employeeid');

        // return $salarydeductionz;

        // return $salarydeductions;

        return view('employees.deductions.' . $which . '.index')->with($which, $salarydeductionz);

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
    public function store(Request $request, $which)
    {

        $salarydeductions = SalaryDeductions::all();


        $request->validate([
            'ename' => ['required', new ValidEmployee],
            'amount' => 'required|numeric',
            'date' => 'required'
        ]);



        $employeename = $request->get('ename');
        $employeesname = explode(", ", $employeename);

        //this is original code sir
        $eid = Employee::select('employeeid')
            ->where('lname', $employeesname[0])
            ->where('fname', $employeesname[1])
            ->value('employeeid');

        //this is where it separates itself from 
        foreach ($salarydeductions as $salarydeduction) {
            if ($salarydeduction->employeeid == $eid && $which == $salarydeduction->deductiontypeid) {
                return redirect()->back()->with('error', 'Employee Duplicate Found');
                break;
            }
        }

        $salarydeduction = new SalaryDeductions([
            'deductiontypeid' => $which,
            'employeeid' => $eid,
            'amount' => $request->get('amount'),
            'date' => $request->get('date')
        ]);
        $salarydeduction->save();

        $which = strtoupper($which);

        // return ($which);

        return redirect()->back()->with('success', $which . ' has been added');

        //return redirect('/payroll/deductions/types')->with('success', 'Deduction type has been added');


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($where, $id)
    {
        global $which;

        $salarydeductions = SalaryDeductions::all()->where('employeeid', $id);
        $salarydeductions = $salarydeductions->where('deductiontypeid', $which);
        //$name = $loans->employeez->lname.' '.$loans->employeez->fname;
        //$name = Employee::find($id);
        //$name = $name->lname.', '.$name->fname;
        $name = SalaryDeductions::with('employeez')->where('employeeid', $id);

        $title = $which . ' Transactions of ';
        //$balance = $loans->sum('amount');



        return view('employees.deductions.' . $where . '.show')->with('title', $title)->with('salarydeductions', $salarydeductions)->with('name', $name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($where, $id)
    {
        $employee = SalaryDeductions::with('employeez')->where('salarydeductionsid', $id)->get();

        // return $employee;

        // return $employee;
        return view('employees.deductions.edit')->with('employee', $employee)->with('which', $where);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $which, $id)
    {
        $request->validate(['amount'=>'required|numeric']);

        $pascua = SalaryDeductions::find($id);
        $pascua->amount = ($request->input('amount'));
        $pascua->save();

        
        return redirect()->back()->with('success', 'Contribution Saved');

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




    /*public function pogi()
    {
        global $which;
        return redirect('employees/deductions/meme');

    }*/
}
