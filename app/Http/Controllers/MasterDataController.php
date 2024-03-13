<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function getAllActiveUsers(Request $request)
    {
        $users = User::where('status','Active')->get();

        return apiResponse(0,'success',$users);
    }
    public function getAllActiveJobs(Request $request)
    {
        $jobs = Job::where('status','Active')->get();

        return apiResponse(0,'success',$jobs);
    }

}
