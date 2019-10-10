<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Employee;
use App\InventoryTransfer;
use App\Inventory;
use App\Skill;

class InventoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $inventorys = Inventory::all();

        $skills = Skill::all();

        return view('inventorys.all')->with('inventorys', $inventorys)->with('skills', $skills);
    }

    public function index()
    {

        $inventorys = Inventory::with('skillz')->get();
        $skills = Skill::with('inventoryz')->where('active', 1)->get();

        // return $skills;
        return view('inventory.try')->with('inventorys', $inventorys)->with('skills', $skills);


        // return $inventorys;

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventorys');
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
            'name' => 'required',
            'classification' => 'required',
            'quantity' => 'required'
        ]);

        $inventory = new Inventory([
            'name' => $request->get('name'),
            'classification' => $request->get('classification'),
            'quantity' => $request->get('quantity'),
            'restrictionid' => $request->get('restrictionid')


        ]);
        //return $inventory;
        $inventory->save();

        return redirect()->back()->with('success', 'Inventory has been Added');

        // return redirect('/inventorys')->with('success', 'inventory has been added');

        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $assignments = Assignment::orderBy('assignmentid', 'desc')->get();

    //     $assignments = $assignments->where('active', 1)->where('projectid', $id);

    //     $title = Project::where('projectid', $id)->first()->projectname;


    //     $dtr = DTR::where('projectid', $id)->distinct('date')->pluck('date');

    //     // return $title;
    //     return view('projects.show')->with('projectid', $id)->with('assignments', $assignments)->with('title', $title)->with('dtr', $dtr);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = Inventory::find($id);
        $skills = Skill::all();


        // return $skills;
        return view('inventory.edit')->with('inventorys', $inventory)->with('skills', $skills)->with('inventoryid', $id);
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

        // return $request->all();
        $request->validate([
            'name' => 'required',
            'classification' => 'required',
            'quantity' => 'required|numeric'
        ]);

        $inventoryid = Inventory::find($id);
        $inventoryid->name = $request->get('name');
        $inventoryid->classification = $request->get('classification');
        $inventoryid->quantity = $request->get('quantity');
        $inventoryid->restrictionid = $request->get('restrictionid');



        $inventoryid->save();



        // return 'it worked?';
        return redirect('inventorytransfer/inventory')->with('success', 'Inventory Information has been edited');
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
