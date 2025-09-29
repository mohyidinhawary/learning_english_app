<?php

namespace App\Services;

use App\Repositories\FCMRepository;

class FCMService
{
    protected FCMRepository $fcmRepository;

    public function __construct(FCMRepository $fcmRepository)
    {
        $this->fcmRepository = $fcmRepository;
    }

    public function sendNotificationToTopic(array $data)
    {
        $title = $data['title'] ?? 'No Title';
        $body = $data['body'] ?? 'No Body';
        $topic = $data['topic'] ?? 'general';

        return $this->fcmRepository->sendToTopic($topic, $title, $body);
    }

    public function sendNotificationToDevice(string $deviceToken, string $title, string $body)
    {
        return $this->fcmRepository->sendToDevice($deviceToken, $title, $body);
    }
    public function get_notification($user_id, $user_type)
    {
        return $this->fcmRepository->get_notification($user_id, $user_type);
    }
}
