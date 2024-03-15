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

    public function insertarJob($name, $petitionId)
    {
        
        $job = new Job();
        $job->name = $name;
        $job->petition_id = $petitionId;
        

        $job->save();

        return redirect('/');
    }
}

?>