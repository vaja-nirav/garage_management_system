<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.from');

        if ($sid && $token) {
            $this->client = new Client($sid, $token);
        }
    }

    /**
     * Send SMS Notification
     */
    public function sendSMS($to, $message)
    {
        if (!$this->client) {
            Log::info("Twilio not configured. Message to {$to}: {$message}");
            return false;
        }

        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error("Twilio Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send WhatsApp Notification
     */
    public function sendWhatsApp($to, $message)
    {
        if (!$this->client) {
            Log::info("Twilio (WhatsApp) not configured. Message to {$to}: {$message}");
            return false;
        }

        try {
            $this->client->messages->create("whatsapp:{$to}", [
                'from' => "whatsapp:{$this->from}",
                'body' => $message
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error("Twilio WhatsApp Error: " . $e->getMessage());
            return false;
        }
    }
}
