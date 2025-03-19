<?php

namespace App\Listeners;

use App\Models\UserIpLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LogUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // Fetch Country & ISP
        $geoData = $this->getIpDetails($ip);
        $country = $geoData['country'] ?? 'Unknown';
        $isp = $geoData['isp'] ?? 'Unknown';

        Log::info("User Logged In: {$user->email} | IP: $ip | Country: $country | ISP: $isp | User Agent: $userAgent");

        UserIpLog::create([
            'user_id' => $user->id,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'country' => $country,
            'isp' => $isp,
        ]);
    }

    private function getIpDetails($ip)
    {
        try {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error("IP Geolocation API failed: " . $e->getMessage());
        }

        return [];
    }
}
