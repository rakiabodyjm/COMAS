<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Loan;
use App\Employee;
use App\Project;
use App\Assignment;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $summary = null;




        //$loans=Loan::all()->unique('employeeid');
        $loans = Loan::orderBy('employeeid', 'asc')->get();
        $loanz = $loans->unique('employeeid');
        return view('employees.deductions.loans.index')->with('loans', $loanz);
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
            'ename' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required'
        ]);


        switch ($request->input('loan')) {
            case 'pay':
                $amount = -($request->get('amount'));

                break;

            case 'add':
                $amount = $request->get('amount');
                break;
        }
        $employeename = $request->get('ename');
        $employeesname = explode(", ", $employeename);



        if (!array_key_exists('1', $employeesname)) {

            return redirect('employees/deductions/loans')->with('error', 'Please select employee from suggestion');
        } else {
            $elname = $employeesname[0];
            $efname = $employeesname[1];
        }


        $eid = Employee::select('employeeid')
            ->where('lname', $elname)
            ->where('fname', $efname)
            ->value('employeeid');

        if (empty($eid)) {
            return redirect('employees/deductions/loans')->with('error', 'Please select employee only from suggestion');
        }


        $loan = new Loan([
            'employeeid' => $eid,
            //'amount'=> $request->get('amount'),
            'amount' => $amount,
            'date' => $request->get('date')
        ]);
        $loan->save();

        return redirect('employees/deductions/loans')->with('success', 'Loan has been added');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loans = Loan::all()->where('employeeid', $id);
        //$name = $loans->employeez->lname.' '.$loans->employeez->fname;
        $name = Employee::find($id);
        $name = $name->lname . ', ' . $name->fname;

        $title = 'Loan Transactions of ' . $name;
        $balance = $loans->sum('amount');

        return view('employees.deductions.loans.show')->with('title', $title)->with('loans', $loans)->with('name', $name)->with('balance', $balance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function autocomplete(Request $request)
    {
        //$search = $request->get('term');
        //$result = Employee::select("lname")
        //->where("lname", "LIKE", "%".$search."%")
        //->get();

        $result = Employee::all('lname', 'fname');
        // $result = Employee::all()->only('lname', 'fname');

        return response()->json($result);
    }

    public function dates(Request $request, $date, $project)
    {

        $alldates = Assignment::select('date')->get();
        $alldates = $alldates->unique();

        $selectdate = Assignment::select('employee')->where('date', $date)->where('projectid', $project)->unique();

        return response()->json($selectdate);
    }
}
