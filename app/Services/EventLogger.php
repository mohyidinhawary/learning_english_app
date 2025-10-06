<?php
namespace App\Services;

use App\Models\UserEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EventLogger
{
    // 🔹 تسجيل الحدث داخليًا في قاعدة البيانات
    public static function log(string $name, array $data = []): void
    {
        UserEvent::create([
            'user_id' => Auth::id(),
            'event_name' => $name,
            'event_data' => $data,
        ]);
    }

    // 🔹 (اختياري) إرسال الحدث إلى Firebase Analytics عبر Measurement Protocol
    public static function logToFirebase(string $name, array $params = []): void
    {
        $measurementId = env('FIREBASE_MEASUREMENT_ID');
        $apiSecret = env('FIREBASE_API_SECRET');

        if (!$measurementId || !$apiSecret) {
             logger("❌ Firebase Analytics credentials missing.");
            return; // ما في إعدادات => تجاهل الإرسال
        }

      $response =   Http::post("https://www.google-analytics.com/mp/collect?measurement_id={$measurementId}&api_secret={$apiSecret}&debug_mode=1", [
            'client_id' => (string) (Auth::id() ?: uniqid()),
    'events' => [
                    [
                       'name' => $name,
                'params' => array_merge($params, [
                    'debug_mode' => true, // ضروري
                ]),
                    ],
                ],
    ]
        );


        logger("📡 Firebase Event Sent", [
            'event' => $name,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);




    }

    // 🔹 تسجيل مزدوج (محلي + Firebase)
    public static function record(string $name, array $data = []): void
    {
        self::log($name, $data);
        self::logToFirebase($name, $data);
    }
}
