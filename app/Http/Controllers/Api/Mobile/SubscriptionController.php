<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GooglePlayService;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
class SubscriptionController extends Controller
{
     public function verify(Request $request, GooglePlayService $google)
    {
        $request->validate([
            'product_id' => 'required|string',
            'purchase_token' => 'required|string',
        ]);

        $user = Auth::user();
        $data = $google->verifyPurchase($request->product_id, $request->purchase_token);

        if (!$data) {
            return RB::asError(400)->withMessage('التحقق من الشراء فشل ❌')->build();
        }

        // استخراج تاريخ الانتهاء
        $expiry = isset($data->expiryTimeMillis)
            ? now()->setTimestampMs($data->expiryTimeMillis)
            : null;

        $subscription = Subscription::updateOrCreate(
            ['purchase_token' => $request->purchase_token],
            [
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'type' => $this->mapType($request->product_id),
                'status' => 'active',
                'expires_at' => $expiry,
            ]
        );

        return RB::success([
            'message' => '✅ تم التحقق من الاشتراك بنجاح',
            'subscription' => $subscription,
        ]);
    }

    private function mapType($productId)
    {
        return match (true) {
            str_contains($productId, 'year') => 'yearly',
            str_contains($productId, 'life') => 'lifetime',
            default => 'monthly',
        };
    }
}

