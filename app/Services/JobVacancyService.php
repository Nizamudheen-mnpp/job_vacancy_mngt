<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use App\Models\Vacancy;

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
            $errorMessage = $data->vacancy_id > 0 ? 'Vacancy Updated Successfully.' : 'Vacancy Created Successfully.';
            $errorCode = 0;
        } else {
            $errorMessage = 'Database error...';
            $errorCode = 15;
        }
        return [
            'errorCode'=>$errorCode,
            'errorMessage'=>$errorMessage
        ];
    }


}
