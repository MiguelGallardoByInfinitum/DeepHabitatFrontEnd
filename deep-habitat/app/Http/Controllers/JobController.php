<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    public function mostrarJobs()
    {
        $jobs = Job::all();
        return view('jobs', ['jobs' => $jobs]);
    }

    public function insertarJob($name, $petition_id)
    {
        
        // $job = new Job();
        // $job->name = $name;
        

        // $job->save();

        return redirect('/');
    }
}

?>