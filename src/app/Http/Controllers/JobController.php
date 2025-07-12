<?php

namespace App\Http\Controllers;

use App\Models\JobTask;

class JobController extends Controller
{
    public function list()
    {
        $jobs = JobTask::orderBy('created_at', 'desc')->get();
        return view('jobs.list', compact('jobs'));
    }
}
