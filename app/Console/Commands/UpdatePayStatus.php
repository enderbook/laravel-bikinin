<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PayModel;
use App\Models\KontrakModel;
use App\Models\NotifModel;


class UpdatePayStatus extends Command
{
    
    protected $signature = 'pay:update-status';
    protected $description = 'Update status pay menjadi 1';



    public function handle()
    {
        $pays = PayModel::where('status', 2)->get();

        foreach ($pays as $p) {
            if ($p->poto_client !== null) {
                $this->info("pay poto_client OK: " . $p->id_pay);

                $kontrak = KontrakModel::where('id_kontrak', $p->id_kontrak)->first();

                if ($kontrak) {
                    $this->info("Kontrak ketemu: " . $kontrak->id_kontrak . " | Status: " . $kontrak->status . " | Foto: " . $kontrak->delivarable);

                    if ($kontrak->delivarable !== null) {
                        
                        $p->status = 1;
                        $p->save();
                        $this->info("Status diubah ke 1 untuk pay ID: " . $p->id_pay);
                        
                    }
                } else {
                    $this->info("Kontrak tidak ditemukan untuk pay ID: " . $p->id_pay);
                }
            }
        }
    }

}
