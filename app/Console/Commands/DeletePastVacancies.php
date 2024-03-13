<?php

namespace App\Console\Commands;

use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeletePastVacancies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-past-vacancies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete past scheduled vacancies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get current date and time
        $now = Carbon::now();

        // Delete past vacancies
        Vacancy::where('end_date', '<', $now)->delete();

        $this->info('Past scheduled vacancies deleted successfully.');
    }
}
