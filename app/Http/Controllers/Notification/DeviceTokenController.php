<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string|unique:device_tokens,device_token',
            'device_type'  => 'nullable|in:android,ios,web',
        ]);
        $auth = auth("user-api")->user() ?? auth("client-api")->user();
        $token = $auth->device->first();
        if (!$token) {
            $token = $auth->device()->create(
                [
                    'device_token' => $request->device_token,
                    'device_type'  => $request->device_type,
                ]
            );
        } else {
            $token->update(
                [
                    'device_token' => $request->device_token,
                    'device_type'  => $request->device_type,
                ]
            );
        }


        return response()->json([
            'status' => 'success',
            'data'   => $token,
        ]);
    }
}
