<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message using Fonnte API.
     *
     * @param string $target The destination phone number.
     * @param string $message The text message to send.
     * @return bool
     */
    public static function send($target, $message)
    {
        // Fetch token from config first, then settings DB, then hardcoded fallback
        $token = config('services.fonnte.token');
        if (empty($token)) {
            $token = Setting::get('wa_api_token');
        }
        if (empty($token)) {
            $token = 'VuYtSiZ1GNDuXdGAMHy9';
        }

        if (empty($target) || empty($message)) {
            Log::warning('WhatsApp target or message is empty.');
            return false;
        }

        // Standardize Indonesian phone numbers starting with '0' to '62'
        if (strpos($target, '0') === 0) {
            $target = '62' . substr($target, 1);
        }

        try {
            // Fonnte requires form parameters (x-www-form-urlencoded), so we use ->asForm().
            // ->withoutVerifying() prevents local SSL certificate errors (common on Laragon/XAMPP).
            $response = Http::asForm()
                ->withoutVerifying()
                ->withHeaders([
                    'Authorization' => $token,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62',
                ]);

            if ($response->successful()) {
                Log::info("WhatsApp message successfully sent to {$target}");
                return true;
            } else {
                Log::error("Failed to send WhatsApp to {$target} (Status {$response->status()}): " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Exception occurred while sending WhatsApp to {$target}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }
}
