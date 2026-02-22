<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class UpdateBlockStatus extends Command
{
    protected $signature = 'user:unblock';
    protected $description = 'Unblock users who have been blocked for 30 days';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $now = Carbon::now();

        $users = User::where('status', 2)
            ->where('blocked_at', '<=', $now->subDays(30))
            ->get();

        foreach ($users as $user) {
            $user->status = 1;
            $user->blocked_at = null;
            $user->save();
            $this->info("Unblocked user ID: {$user->id}");
        }

        $this->info('Unblock check completed.');
    }
}
