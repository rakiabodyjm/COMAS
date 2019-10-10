<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Location;
class LocationsController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('projects.locations.index')->with('locations', $locations);

    }
    public function store(Request $request)
    {
        
        $request->validate([
            'location'=>'required',
            'locationsalary'=>'required|numeric',
        ]);

         $location = new Location([
            'location'=> $request->get('location'),
            'locationrate' => $request->get('locationsalary')
        ]);
        $location->save();



        return redirect('/projects/locations');
    }
    public function edit($id)
    {
        $location = Location::find($id);


        return view('projects.locations.edit')->with('location', $location);

        
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'location'=>'required',
            'locationsalary'=>'required|numeric',
        ]);

        $location = Location::find($id);
            $location->location = $request->get('location');
            $location->locationrate = $request->get('locationsalary');
        
        $location->save();

        return redirect('projects/locations')->with('success', 'Location has been edited');
    }
}
