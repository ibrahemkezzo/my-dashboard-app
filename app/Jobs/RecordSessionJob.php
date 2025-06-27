<?php

namespace App\Jobs;

use App\Models\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Job to record session data asynchronously.
 */
class RecordSessionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The session data.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Session::create([
            'session_id' => $this->data['session_id'],
            'device_type' => $this->data['device_type'],
            'country' => $this->data['country'],
            'referrer' => $this->data['referrer'],
            'started_at' => now(),
        ]);
    }
}