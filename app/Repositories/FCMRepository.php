<?php

namespace App\Repositories;

use App\Models\Notification as ModelsNotification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMRepository
{
    protected $messaging;

    public function __construct(string $deviceType = 'web')
    {
        $configPath = match ($deviceType) {
            'web' => config('services.firebase.web.credentials'),
            'android' => config('services.firebase.android.credentials'),
            default => config('services.firebase.android.credentials'),
        };
        $factory = (new Factory)->withServiceAccount($configPath);

        $this->messaging = $factory->createMessaging();
    }

    public function sendToTopic(string $topic, string $title, string $body)
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification);

        return $this->messaging->send($message);
    }

    public function sendToDevice(string $deviceToken, string $title, string $body)
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification);

        return $this->messaging->send($message);
    }
    public function get_notification($user_id, $user_type)
    {
        return ModelsNotification::where('userable_id', $user_id)
            ->where('userable_type', $user_type)
            ->orderByDesc('created_at')
            ->get();
    }
}
