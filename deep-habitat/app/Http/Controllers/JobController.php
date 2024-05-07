<?php

namespace App\Http\Controllers;

use App\Models\Job;

class JobController extends Controller
{
    public function mostrarJobs()
    {
        $jobs = Job::all();
        return view('jobs', ['jobs' => $jobs]);
    }

    public function insertarJob($name, $petitionId, $description)
    {
        
        $job = new Job();
        $job->name = $name;
        $job->petition_id = $petitionId;
        $job->description = $description;
        

        $job->save();

        return redirect('/');
    }
}

?>