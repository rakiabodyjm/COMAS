<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Employee;
use App\InventoryTransfer;
use App\Inventory;
use App\Requests;
use App\Skill;
use App\Rules\ValidEmployee;

class InventoryTransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $inventorytransfers = InventoryTransfer::all();

        // $inventorys=Inventory::all();
        // $employees = Employee::all();
        // $locations= Location::all();


        return view('inventorytransfers.all');
    }

    public function index()
    {

        $inventorytransfers = InventoryTransfer::with(['project1', 'inventoryz'])->get();
        // $skills = Skill::all()->where('active', 1);
        // return ($inventorytransfers);
        //$inventoryEquipment = Inventory::where('classification', 'equipment')->get();
        $inventory = Inventory::all();
        $projects = Project::where('status', 1)->get();
        $equipments = collect();
        foreach ($inventorytransfers as $i) {
            if ($i->inventoryz->classification == 'Equipment') {
                $equipments->push($i);
            }
        }
        $inventoryMaterial = Inventory::where('classification', 'material')->get();

        $materials = collect();
        foreach ($inventorytransfers as $i) {
            if ($i->inventoryz->classification == 'Material') {
                $materials->push($i);
            }
        }


        // return $equipments;
        // return $inventoryEquipment;
        return view('inventory.inventorytransfer.index')->with('inventorytransfers', $inventorytransfers)->with('inventory', $inventory)->with('ifEquipment', $equipments)->with('ifMaterial', $materials)->with('projects', $projects);

        //return $inventorys;
        // $inventoryMaterial = Inventory::where('classification', 'material')->get();

        // $materials = collect();
        // foreach ($inventorytransfers as $i) {
        //     if ($i->inventoryz->classification == 'Material') {
        //         $equipments->push($i);
        //     }
        // // }
        // return view('inventory.inventorytransfer.index')->with('inventorytransfers', $inventorytransfers)->with('inventory', $inventoryMaterial)->with('ifMaterial', $materials);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventorytransfers');
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

            'quantity' => 'required'

        ]);

        $inventorytransfer = new InventoryTransfer([
            'inventoryid' => $request->get('inventoryid'),
            'projectname' => $request->get('projectname'),
            'employeeid' => $request->get('employeeid'),
            'quantity' => $request->get('quantity'),

            'date' => $request->get('date')


        ]);

        $inventorytransfer->save();

        return redirect()->back()->with('success', 'Inventory info has been Added');

        // return redirect('/inventorys')->with('success', 'inventory has been added');

        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventorytransfer = InventoryTransfer::where('transferid', $id)->get();
        $inventorytransfer = $inventorytransfer->map(function ($q) {
            $q->projectname = $q->project1->projectname;
            $q->employeename = $q->employeez->full_name;
            $q->inventoryname = $q->inventoryz->name;
            return $q->only(['transferid', 'inventoryname', 'inventoryid', 'projectname', 'employeename', 'quantity']);
        });
        return $inventorytransfer->first();

        // return $id;
        // return view('inventory.inventorytransfer.edit')->with('inventory', $inventorytransfer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transferid)
    {
        $request->validate([
            'projectname' => 'required',
            'quantity' => 'required'

        ]);

        $inventorytransfer = new InventoryTransfer([
            'inventoryid' => $request->get('inventoryid'),
            'projectname' => $request->get('projectname'),
            'employeeid' => $request->get('employeeid'),
            'quantity' => $request->get('quantity'),
            'date' => $request->get('date')


        ]);
        $inventorytransfer->save();

        //return 'it worked?';
        return redirect('/inventorytransfer')->with('success', 'Inventory Information has been edited');
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
    public function puta(Request $request)
    {
        // return $request->all();
        $vakue = $request->input('select');
        $empname = $request->input('ename');

        $request->validate([

            'ename' =>  ['required', new ValidEmployee]
        ]);


        $inventorynames = array();
        $limit = count($vakue);
        $i = 0;

        foreach ($vakue as $v) {

            $input = $request->input($v);
            if ($input == null) {
                $inventoryname = Inventory::find($v)->name;

                array_push($inventorynames, $inventoryname);
            }
            $i++;
            if ($limit == $i && count($inventorynames) > 0) {
                return redirect()->back()->with('error', "Missing Number Input for " . implode(' | ', $inventorynames));
            }
        }
        $myArray = explode(', ', $empname);

        $array1 = $myArray[0];
        $array2 = $myArray[1];

        $employee = Employee::with('assignmentz');
        $employeeborrower = $employee->where('lname', $array1)->where('fname', $array2)->get()->first();

        // $hellofname = Employee::where('fname', $array2)->where('lname', $array1)->get();

        $sdfnoadnsflkn = collect();

        $sdfnoadnsflkn->push(array('Employee Name' => $empname));
        // return $sdfnoadnsflkn;

        //return $employee->assignmentz->projectz['projectname'];

        if ($employeeborrower->assignmentz->projectz['projectid'] == null) {
            return redirect()->back()->with('error', 'Employee has no Assigned Project please Assign First');
        }
        foreach ($vakue as $val) {
            $inventorytransfer = new InventoryTransfer([
                'name' => $val,
                'inventoryid' => $val,
                'projectname' => $employeeborrower->assignmentz->projectz['projectid'],
                'employeeid' => $employeeborrower->employeeid,
                'quantity' => $request->input($val),

                'date' => (date('Y-m-d'))


            ]);
            $inventorytransfer->save();
            $i = Inventory::find($val);
            $i->quantity = $i->quantity - $request->input($val);
            $i->save();
        }


        $inventorytransfer->save();
        return redirect()->back()->with('success', 'Checkout has been made');

        return $inventorytransfer;
    }




    // request module
    public function indexrequest()
    {

        $employees = InventoryTransfer::with(['employeez', 'inventoryz'])->get();;
        $requezt = Requests::all();
        $requezt = $requezt->sortByDesc('date');
        return view('request.index')->with('requestz', $requezt)->with('employees', $employees);
    }

    public function delete(Request $request, $requestid)
    {

        $requezt = Requests::find($requestid);

        $requezt->delete();

        $response = array('success' => $requezt->message . ' deleted');
        return $response;
    }
    public function accept($requestid)
    {


        $requezt = Requests::find($requestid);

        // $transid = InventoryTransfer::find($requezt)->transferid;
        // $transferquantity = InventoryTransfer::find($transid)->quantity;
        // $q = Requests::find(requestid)->quantity;
        // // $invid = Request::find($requezt)->first()->inventoryid;


        $$requezt->delete();

        $response = array('success' => $requezt->message . ' accepted');
        return $response;
    }



    //end of request module

    public function quantity(Request $request)
    {

        $radioSelected = $request->input('lyra');
        $project = $request->input('project');
        $q = $request->input('quantity');
        $transid = $request->input('transferid');
        $invid = $request->input('inventoryid');
        $empid = InventoryTransfer::find($transid)->employeeid;

        $transferquantity = InventoryTransfer::find($transid)->quantity;

        if ($radioSelected == 'transfer') {

            $plast = InventoryTransfer::find($transid)->first()->projectname;
            $pastproject = Project::find($plast)->projectname;
            $newproject = Project::find($project)->projectname;
            $invname = Inventory::find($invid)->name;
            $employeename = Employee::find($empid)->full_name;

            $insertrequest = new Requests(
                [
                    'inventoryname' => $invname,
                    'quantity' => $q,
                    'profrom' => $pastproject,
                    'proto' => $newproject,
                    'employeename' => $employeename,
                    'date' => date('Y-m-d')
                ]
            );


            $insertrequest->save();






            if ($transferquantity == $q) {

                $inventorytransfer = new InventoryTransfer([

                    'inventoryid' => $invid,
                    'projectname' => $project,
                    'employeeid' => $empid,
                    'quantity' => $q,
                    'status' => null,
                    'date' => (date('Y-m-d'))
                ]);
                $inventorytransfer->save();
                $oldtransid = InventoryTransfer::find($transid);
                $oldtransid->delete();
                return redirect()->back()->with('success', 'Transfer has been made');
            } elseif ($transferquantity > $q) {

                $inventorytransfer = new InventoryTransfer([
                    'inventoryid' => $invid,
                    'projectname' => $project,
                    'employeeid' => $empid,
                    'quantity' => $q,

                    'date' => (date('Y-m-d'))
                ]);
                $inventorytransfer->save();
                $oldtransid = InventoryTransfer::find($transid);
                $oldtransid->quantity = $transferquantity - $q;
                $oldtransid->update();

                //return $inventorytransfer;
                return redirect()->back()->with('success', 'Transfer has been made');
            }
        } else {
            if ($transferquantity == $q) {
                $oldtransid = InventoryTransfer::find($transid);
                $oldtransid->delete();

                $inventoryid = Inventory::find($invid);
                $availablequantity = Inventory::find($inventoryid)->first()->quantity;
                //return $availablequantity;
                $inventoryid->quantity = $availablequantity + $q;
                $inventoryid->update();
                return redirect()->back()->with('success', 'Items successfully returned');
            } else {
                $oldtransid = InventoryTransfer::find($transid);
                $oldtransid->quantity = $transferquantity - $q;
                $oldtransid->update();

                $inventoryid = Inventory::find($invid);
                $availablequantity = Inventory::find($inventoryid)->first()->quantity;
                $inventoryid->quantity = $availablequantity + $q;
                $inventoryid->update();
                return redirect()->back()->with('success', 'Items successfully returned');
            }
        }
    }
    public function materialdelete(Request $request)
    {
        $q = $request->input('Quantity');
        $transid = $request->input('Transferid');
        $oldtransid = InventoryTransfer::find($transid);
        //return $oldtransid;
        $availablequantity = InventoryTransfer::find($transid)->quantity;

        if ($availablequantity == $q) {
            $oldtransid->delete();
        } elseif ($availablequantity > $q) {
            $oldtransid->quantity = $availablequantity - $q;
            $oldtransid->update();
        }
        return redirect()->back()->with('Success', 'Items successfully deleted');
    }
}
