<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\NotificationService;

class VehicleReady extends Notification
{
    use Queueable;

    protected $jobCard;

    /**
     * Create a new notification instance.
     */
    public function __construct($jobCard)
    {
        $this->jobCard = $jobCard;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        // For now, we use a custom logic or just return empty for default
        // We will trigger the SMS manually or via a custom channel if needed
        return ['database']; 
    }

    /**
     * Send via Twilio SMS using our service
     */
    public function toTwilio($notifiable)
    {
        $service = new NotificationService();
        $customerName = $this->jobCard->customer->first_name;
        $vehicle = $this->jobCard->vehicle->registration_number;
        
        $message = "Hello {$customerName}, your vehicle ({$vehicle}) is now ready! Please visit the garage to collect it. Thank you for choosing us!";
        
        return $service->sendSMS($notifiable->phone, $message);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'job_card_id' => $this->jobCard->id,
            'message' => "Vehicle {$this->jobCard->vehicle->registration_number} is ready for delivery.",
        ];
    }
}
