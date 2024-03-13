<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use App\Models\User;
use App\Models\Vacancy;
use App\Services\JobVacancyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class JobVacancyController extends Controller
{
    protected $jobVacancyService;
    public function __construct(JobVacancyService $jobVacancyService)
    {
        $this->jobVacancyService  = $jobVacancyService;
    }

    public function index(Request $request)
    {
        return view('pages.job_vacancies');
    }

    public function list(Request $request)
    {
        $jobVacancy = Vacancy::with('job')->paginate(config('settings.pagination.perPage'));
        
        $response['pagination'] = generatePaginationData($jobVacancy);
        $response['data'] = $jobVacancy;
        return apiResponse(0, 'success', $response);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'job_id' => 'required|exists:jobs,id',
            'status' => 'required|in:Active,Inactive',
            'description' => 'nullable|string',
            'vacancy_id' => 'nullable|exists:vacancies,id',
        ]);
    
        try {
            return $this->jobVacancyService->addEditJobVacancy($request);
        } catch (\Exception $e) {
            return apiResponse(10,$e->getMessage());
        }
        

        
    }

    public function destroy($vacancyId)
    {
        try {
            Vacancy::where('id',$vacancyId)->delete();
            return apiResponse(0,'Successfully deleted');
        } catch (\Exception $e) {
            return apiResponse(10,$e->getMessage());
        }        
    }
}
