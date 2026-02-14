<?php

namespace App\Console\Commands;

use App\Notifications\RenewalReminderNotification;
use App\Notifications\SubscriptionExpiredNotification;
use App\Services\SubscriptionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class CheckSubscriptionsCommand extends Command
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Check expired subscriptions, suspend salons, and send reminders';

    protected $service;

    public function __construct(SubscriptionService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): int
    {
        Log::info('--- [Subscription Cron: Started] ---');
        $this->info('Starting subscriptions check...');

        try {
            // 1. مرحلة التذكيرات
            Log::info('Step 1: Processing renewal reminders...');
            $subscriptionReminders = $this->service->sendRenewalReminders();

            if ($subscriptionReminders->isEmpty()) {
                Log::info('No subscriptions found for renewal reminders.');
            } else {
                foreach ($subscriptionReminders as $subscription) {
                    $owner = $subscription->salon->owner;
                    Notification::send($owner, new RenewalReminderNotification($subscription));

                    Log::info("Reminder sent to Salon: [{$subscription->salon->name}], Owner Email: [{$owner->email}]");
                    $this->line("Sent reminder to: {$subscription->salon->name}");
                }
            }

            // 2. مرحلة الاشتراكات المنتهية
            Log::info('Step 2: Processing expired subscriptions...');
            $expired = $this->service->findExpired();

            if ($expired->isEmpty()) {
                Log::info('No expired subscriptions found.');
            } else {
                foreach ($expired as $subscription) {
                    // إيقاف الاشتراك والصالون
                    $this->service->expired($subscription);

                    $owner = $subscription->salon->owner;
                    Notification::send($owner, new SubscriptionExpiredNotification($subscription));

                    Log::warning("Subscription EXPIRED and Salon DEACTIVATED: [{$subscription->salon->name}], ID: [{$subscription->id}]");
                    $this->warn("Deactivated: {$subscription->salon->name}");
                }
            }

            Log::info('--- [Subscription Cron: Completed Successfully] ---', [
                'reminders_count' => $subscriptionReminders->count(),
                'expired_count' => $expired->count()
            ]);

            $this->info('Done!');

        } catch (\Exception $e) {
            Log::error('--- [Subscription Cron: FAILED] ---', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            $this->error('An error occurred during the check. Check logs for details.');
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
