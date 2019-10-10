<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DTR;
use App\Project;

class DashboardController extends Controller
{
    public function index()
    {

        // $finalPayroll = $finalPayroll->map(function ($q) { });


        return view('dashboard')->with('payrolldata', $this->chart());
    }

    public function chart()
    {
        $dateTo = date('Y-m-d');
        $dateFrom = date('Y-m-d', strtotime('-5 days'));

        // $finalPayroll = DTR::whereBetween('date', [$dateFrom, $dateTo])->get();
        $finalPayroll = DTR::all();
        $projects = array();


        $container = collect();
        $projectids = $finalPayroll->pluck('projectid')->unique()->values();
        foreach ($projectids as $p) {
            $collection = $finalPayroll->where('projectid', $p);
            $total = 0;

            $newCollection = $collection->map(function ($q) use ($total) {
                if ($q->assignmentz != null) {
                    $total = $total + intval($q->assignmentz['employeez']['pay']);
                } else {
                    $total = $total + intval($q->summonz->assignmentz->employeez->pay);
                }
                $q->total = $total;
                return $q->only(['projectid', 'total']);
            });


            $container->push(array('projectid' => $p, 'total' => $newCollection->sum('total')));
        }
        $container = $container->map(function ($q) {
            $project = Project::find($q['projectid'])->projectname;
            $q['projectname'] = strtok($project, ' ');

            return $q;
        });

        return $container;
    }
    public function graph()
    {
        $dateTo = date('Y-m-d');
        $dateFrom = date('Y-m-d', strtotime('-7 days'));

        $finalPayroll = DTR::whereBetween('date', [$dateFrom, $dateTo])->get();

        $dates =  $finalPayroll->pluck('date')->unique()->values();

        $sh = collect();
        foreach ($dates as $d) {
            $dtr = DTR::where('date', $d)->get();
            $dtr = $dtr->map(function ($q) { });

            $sh->push(array('date' => $d, 'DTR' => $dtr));
        }
        return $sh;
        $mamamue = $sh->map(function ($q) {
            return $q;
        });
        return $mamamue;
    }
}
