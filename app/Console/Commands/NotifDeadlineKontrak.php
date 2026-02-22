<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KontrakModel;
use App\Models\NotifModel;

use Carbon\Carbon;

class NotifDeadlineKontrak extends Command
{
    protected $signature = 'kontrak:dealine-kontrak';
    protected $description = 'create notif deket deadline';

    public function handle()
    {
        $today = Carbon::today();
        $kontrakList = KontrakModel::select('tb_kontrak.*',
        'client.username as client_name',
        'freelancer.username as free_name',
        'client.id_user as id_client',
        'jobs.judul as judul_name')

        ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->whereDate('tgl_akhir', '>=', $today)
            ->whereDate('tgl_akhir', '<=', $today->copy()->addDays(10)) // Deadline H-3
            ->where('tb_kontrak.status', '!=', 8)
            ->get();

        foreach ($kontrakList as $kontrak) {
            NotifModel::create([
                'id_user' => $kontrak->id_free,
                'judul_notif' => "Deadline Kontrak Sudah Dekat!",
                'bagian' => 2,
                'status' => 0,
                'des_notif' => "Deadline kontrak job : {$kontrak->judul_name} dari client : {$kontrak->client_name} tinggal beberapa hari lagi!"
            ]);
        }

        $this->info(count($kontrakList) . " kontrak berhasil dikirimin notif deadline.");
    }

}
