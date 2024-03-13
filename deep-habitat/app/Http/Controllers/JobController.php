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

    public function insertarJob($name, $url)
    {
        $job = new Job();
        $job->name = $name;
        $job->url = $url;

        $job->save();

        return redirect('/');
    }
}

?>