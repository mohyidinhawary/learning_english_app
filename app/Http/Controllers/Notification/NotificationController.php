<?php

namespace App\Http\Controllers\Notification;

// use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Models\Log;
use App\Models\User;
use App\Services\FCMService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FCMService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendNotificationToTopic($data)
    {

        $response = $this->firebaseService->sendNotificationToTopic($data);

        return response()->json($response);
    }

    public function sendNotificationToDevice(Request $request)
    {
        $deviceToken = $request->input('device_token');
        $title = $request->input('title');
        $body = $request->input('body');
        $user = auth("client-api")->user();
        $service = new NotificationService('android');
        return $service->sendToUser(
            $user,
            'Task updated',
            "خرا ع يحيى من هون لدرعا ",
            "android"
        );
        // $response = $this->firebaseService->sendNotificationToDevice($deviceToken, $title, $body);

        return response()->json($response);
    }

    public function get_notification(Request $request)
    {
        if (auth("user-api")->check()) {
            $user = auth("user-api")->user();
            $user_id = $user->id;
            $user_type = "User";
        } elseif (auth("client-api")->check()) {
            $user = auth("client-api")->user();
            $user_id = $user->id;
            $user_type = "Client";
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $response = $this->firebaseService->get_notification($user_id, $user_type);
       return RB::success([$response]);
    }



    // public function get_logs(Request $request)
    // {
    //     $logs = Log::with('user')
    //         ->year($request->year)
    //         ->month($request->month)
    //         ->day($request->day)
    //         ->get();

    //     return ApiResponse::respond('OK', LogResource::collection($logs));
    // }
}
