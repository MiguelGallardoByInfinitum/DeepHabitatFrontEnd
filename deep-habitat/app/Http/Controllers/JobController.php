<?php

namespace App\Http\Controllers;

use App\Models\Job;

class JobController extends Controller
{
    public function obtenerJobs()
    {
        $jobs = Job::all();
        return ['jobs' => $jobs];
    }

    public function mostrarJobs()
    {
        $jobs = Job::all();
        return view('jobs', ['jobs' => $jobs]);
    }
}

?>