<?php

namespace App\Services;

use App\Mail\NotificationMail;
use App\Models\Job;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Mail;

class JobVacancyService
{
    public function addEditJobVacancy($data = null)
    {
        $vacancy = Vacancy::updateOrCreate(
            [
                'id' => $data->vacancy_id
            ],
            [
                'start_date' => $data->start_date,
                'end_date' => $data->end_date,
                'job_id' => $data->job_id,
                'status' => $data->status,
                'description' => $data->description,
            ]
        );

        if ($vacancy) {
            if(!$data->vacancy_id){
                $this->sendJobNotification($vacancy->id);
            }
            $errorMessage = $data->vacancy_id > 0 ? 'Vacancy Updated Successfully.' : 'Vacancy Created Successfully.';
            $errorCode = 0;
        } else {
            $errorMessage = 'Database error...';
            $errorCode = 15;
        }
        return apiResponse($errorCode,$errorMessage,$vacancy);

    }


    public function sendJobNotification($vacancyId)
    {
        $users = User::all();
        $jobVacancy = Vacancy::with('job')->where('id',$vacancyId)->first();
    
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationMail($user, $jobVacancy));
        }
    }
}
