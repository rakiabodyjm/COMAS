<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skill;


class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $skills = Skill::all();

        return view('employees.skills.index')->with('skills', $skills);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     **/

    public function create()
    {
        return view('employees.skills');
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
            'skilldescription' => 'required',
            'skillsalary' => 'required|numeric'
        ]);

        $skill = new Skill([
            'description' => $request->get('skilldescription'),
            'salaryrate' => $request->get('skillsalary')
        ]);

        $skill->save();

        return redirect('employees/skills')->with('success', 'Skill has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skill = Skill::find($id);

        return view('employees.skills.edit')->with('skill', $skill);
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
            'skilldescription' => 'required',
            'skillsalary' => 'required|numeric'
        ]);

        $skill = Skill::find($id);
        $skill->description = $request->get('skilldescription');
        $skill->salaryrate = $request->get('skillsalary');
        $skill->active = $request->get('active');

        $skill->save();

        return redirect('employees/skills')->with('success', 'Skill has been edited');
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
