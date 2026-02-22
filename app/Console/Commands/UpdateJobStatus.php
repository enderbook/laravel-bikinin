<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobModel;
use Carbon\Carbon;

class UpdateJobStatus extends Command
{
    protected $signature = 'job:update-status';
    protected $description = 'Update status job menjadi 8 jika melewati deadline';

    public function handle()
    {
        $today = Carbon::today();


        $updatedTo8 = JobModel::where('tgl_akhir', '<', $today)
            ->where('status', '!=', 8)
            ->update(['status' => 8]);

        $this->info("$updatedTo8 job diperbarui menjadi status 8.");
    }


}
