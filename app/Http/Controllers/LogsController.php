<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
class LogsController extends Controller
{
    public function index()
    {
        $log = Log::all();
        $log = $log->sortByDesc('time');
        return view('logs.index')->with('log',$log);
    }
}
