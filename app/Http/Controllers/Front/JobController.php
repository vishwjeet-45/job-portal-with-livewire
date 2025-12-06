<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.jobs.index');
    }

    public function show(Request $request,$encryptedId)
    {
        $jobId = decrypt($encryptedId);
        $job = Job::where('id',$jobId)->first();
        dd($job);
    }
}
