<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
        public function send(string $to, string $message): bool
        {
            $driver = config('services.whatsapp.driver', 'ultramsg');
    
            return match ($driver) {
                'ultramsg' => $this->sendViaUltraMsg($to, $message),
                'meta'     => $this->sendViaMeta($to, $message),
                default    => throw new \Exception("Unsupported WhatsApp driver: {$driver}"),
            };
        }


    // ─────────────────────────────────────────────
    // UltraMsg (الأسهل — بس HTTP request)
    // ─────────────────────────────────────────────
    private function sendViaUltraMsg(string $to, string $message): bool
    {
        try {
            $instance = config('services.whatsapp.ultramsg_instance');
            $token    = config('services.whatsapp.ultramsg_token');

            $response = Http::asForm()
                ->post("https://api.ultramsg.com/{$instance}/messages/chat", [
                    'token'  => $token,
                    'to'     => $this->formatNumber($to),
                    'body'   => $message,
                ]);

            if ($response->failed()) {
                Log::error('UltraMsg WhatsApp failed', [
                    'to'     => $to,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return false;
            }

            Log::info('WhatsApp sent via UltraMsg', ['to' => $to]);
            return true;

        } catch (\Exception $e) {
            Log::error('UltraMsg exception', ['error' => $e->getMessage()]);
            return false;
        }
    }


    // ─────────────────────────────────────────────
    // Meta (WhatsApp Business API)
    // ─────────────────────────────────────────────
    private function sendViaMeta(string $to, string $message): bool
    {
        try {
            $token         = config('services.whatsapp.meta_token');
            $phoneNumberId = config('services.whatsapp.meta_phone_number_id');

            $response = Http::withToken($token)
                ->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to'                => $this->formatNumber($to),
                    'type'              => 'text',
                    'text'              => ['body' => $message],
                ]);

            if ($response->failed()) {
                Log::error('Meta WhatsApp failed', [
                    'to'     => $to,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return false;
            }

            Log::info('WhatsApp sent via Meta', ['to' => $to]);
            return true;

        } catch (\Exception $e) {
            Log::error('Meta exception', ['error' => $e->getMessage()]);
            return false;
        }
    }

    // ─────────────────────────────────────────────
    // Helper
    // ─────────────────────────────────────────────
    private function formatNumber(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        return '+' . $clean;
    }
}