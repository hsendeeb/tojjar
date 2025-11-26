<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Models\User;
use App\Mail\SubscriptionExpired;
use App\Models\Ad;
use Illuminate\Support\Facades\Mail;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get expired subscriptions and their associated users
        
    
    // ...existing code...
    
    
        $expiredSubscriptions = Subscription::where('is_active', true)
            ->where('ends_at', '<', now())
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            // Update subscription status
            $subscription->update(['is_active' => false]);
            
            // Update the associated user's premium status
            if ($subscription->user) {
                $subscription->user->update(['premium' => false]);
                   Ad::where('user_id', $subscription->user_id)
                   ->where('boosted', true)
                   ->update(['boosted' => false]);
            }
            Mail::to($subscription->user->email)->send(new SubscriptionExpired($subscription->user));
        }
    }
}
