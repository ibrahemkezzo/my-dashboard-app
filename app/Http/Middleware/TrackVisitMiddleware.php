<?php

namespace App\Http\Middleware;

use App\Jobs\RecordSessionJob;
use App\Jobs\RecordVisitJob;
use App\Models\Session as ModelsSession;
use Closure;
use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to track website visits, recording session data once and visit activity per request.
 */
class TrackVisitMiddleware
{
    /**
     * The MobileDetect instance.
     *
     * @var MobileDetect
     */
    protected MobileDetect $mobileDetect;

    /**
     * Create a new middleware instance.
     *
     * @param MobileDetect $mobileDetect
     */
    public function __construct(MobileDetect $mobileDetect)
    {
        $this->mobileDetect = $mobileDetect;
    }

    /**
     * Handle an incoming request and record session/visit details.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(session()->key('value'));

        // dd(Session::getId());
        $sessionId = Session::getId();
        $user_id = Auth::check() ? Auth::user()->id : null;
        // dd($sessionId);
        // Check if session is new
        if (!Cache::has("session_tracked_{$sessionId}")) {
            $deviceType = $this->mobileDetect->isMobile() ? 'mobile' : ($this->mobileDetect->isTablet() ? 'tablet' : 'desktop');
            $ip = $request->ip();
            $country = Cache::remember("ip_country_{$ip}", now()->addHours(24), function () use ($ip) {
                return \Stevebauman\Location\Facades\Location::get($ip)->countryName ?? null;
            });
            $referrer = $request->header('referer') ?? 'direct';

            // Dispatch job to record session data
            // RecordSessionJob::dispatch([
            //     'session_id' => $sessionId,
            //     'user_id' => $user_id,
            //     'device_type' => $deviceType,
            //     'country' => $country,
            //     'referrer' => $referrer,
            // ]);

            ModelsSession::updateOrCreate([
            'session_id' => $sessionId,
            'device_type' => $deviceType,
            'country' => $country,
            'referrer' => $referrer,
            'started_at' => now(),
            ]);

            // Mark session as tracked
            Cache::put("session_tracked_{$sessionId}", true, now()->addHours(24));
        }
        else{
            if(($user_id != null) && (ModelsSession::where('session_id', $sessionId)->first()->user_id == null)){
                ModelsSession::where('session_id', $sessionId)->update(['user_id' => $user_id]);
            }
            else{
                ModelsSession::where('session_id', $sessionId)->update(['updated_at' => now()]);
            }
        }
        // Dispatch job to record visit activity
        RecordVisitJob::dispatch([
            'session_id' => $sessionId,
            'page_url' => $request->path(),
        ]);

        return $next($request);
    }
}
