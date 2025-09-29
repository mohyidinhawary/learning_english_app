<?php

namespace App\Services;

use App\Models\DeviceToken;
use App\Models\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;
use Exception;

class NotificationService
{
    protected $messaging;

    public function __construct(string $deviceType = 'android')
    {
        $configPath = match ($deviceType) {
            'web' => config('services.firebase.web.credentials'),
            'android' => config('services.firebase.android.credentials'),
        };

        $factory = (new Factory)->withServiceAccount($configPath);
        $this->messaging = $factory->createMessaging();
    }
    /**
     * إرسال إشعار لمستخدم واحد
     */
    public function sendToUser($user, string $title, string $body, string $deviceType )
    {
        $userId   = $user->id;
        $userType = basename(get_class($user)); // ex: App\Models\User أو App\Models\Client

        $tokens = DeviceToken::where('deviceable_id', $userId)
            ->where('deviceable_type', $userType)
            ->where('device_type', $deviceType)
            ->pluck('device_token');
        
        if ($tokens->isEmpty()) {
            return $this->storeNotification($userId, $userType, $title, $body, 'failed');
        }

        foreach ($tokens as $token) {
            try {
                $notification = FCMNotification::create($title, $body);
                $message = CloudMessage::withTarget('token', $token)
                    ->withNotification($notification);


                $this->messaging->send($message);
                $this->storeNotification($userId, $userType, $title, $body, 'sent');
            } catch (Exception $e) {
                $this->storeNotification($userId, $userType, $title, $body, 'failed');
            }
        }
    }

    /**
     * تخزين الإشعار بالـ DB
     */
    protected function storeNotification(int $userId, string $userType, string $title, string $body, string $status)
    {
        return Notification::create([
            'userable_id'   => $userId,
            'userable_type' => $userType,
            'title'         => $title,
            'body'          => $body,
            'status'        => $status,
        ]);
    }
}
