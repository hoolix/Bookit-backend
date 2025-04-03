<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class CleanExpiredTokens extends Command
{
    // The name and signature of the console command.
    protected $signature = 'tokens:clean-expired';

    // The console command description.
    protected $description = 'Delete expired tokens from the personal_access_tokens table';

    // Execute the console command.
    public function handle()
    {
        $expiredTokens = PersonalAccessToken::where('expires_at', '<', Carbon::now())
                                             ->orWhere('expires_at', null)
                                             ->get();

        foreach ($expiredTokens as $token) {
            $token->delete();
        }

        $this->info('Expired tokens cleaned up!');
    }
}
