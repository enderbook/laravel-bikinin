<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobModel;
use App\Models\KontrakModel;
use App\Models\PenawaranModel;

class BersihProjek extends Command
{
    protected $signature = 'projek:bersih';
    protected $description = 'bersih database gw';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $jobs = JobModel::where('status', 10)->get();
        $deletedCount = 0; // Buat ngitung berapa yang kehapus

        foreach ($jobs as $job) {
            $penawaran = PenawaranModel::where('id_job', $job->id_job)->exists();
            $kontrak = KontrakModel::where('id_job', $job->id_job)->exists();

            if (!$penawaran && !$kontrak) {
                // Kalau nggak ada penawaran dan kontrak, HAPUS
                $job->delete();
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            $this->info("$deletedCount job berhasil disingkirkan. 🧹");
        } else {
            $this->info('Nggak ada job yang bisa disingkirkan. 🔥');
        }
    }
}
