<?php

namespace App\Console\Commands;

use App\Notifications\SubscriptionExpiredNotification;
use App\Services\SubscriptionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expired subscriptions, suspend salons, and send reminders/emails';

    protected $service;

    public function __construct(SubscriptionService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     */
public function handle(): int
    {
        $this->info('Starting subscriptions check...');

        // 1. إرسال تذكيرات للاشتراكات اللي رح تنتهي قريبًا (مثل قبل 5 أيام)
        $this->service->sendRenewalReminders();

        // 2. الاشتراكات المنتهية: إيقاف الصالون + إرسال إيميل انتهاء
        $expired = $this->service->findExpired(); // من Repository

        foreach ($expired as $subscription) {
            // إيقاف الاشتراك والصالون
            $this->service->expired($subscription); // أو ميثود منفصل لـ expire

            // إرسال إيميل انتهاء
            Notification::send($subscription->salon->owner, new SubscriptionExpiredNotification($subscription));
        }

        $this->info('Subscriptions check completed. Processed ' . $expired->count() . ' expired subscriptions.');

        return self::SUCCESS;
    }
}
