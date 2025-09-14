<?php

namespace App\Http\Controllers\Api\Mobile\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OtpRequest;
use App\Models\Otp;
use App\Helpers\ApiResponse;
use Illuminate\Validation\ValidationException;
use App\Mail\OtpEmail;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\ValidateOtpRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;


class OtpController extends Controller
{

    public function SendOtp(SendOtpRequest $request)
    {
        try {
            $email = $request->validated()['email'];  // استخراج الإيميل بشكل صحيح
            $otp = rand(100000, 999999);  // مولّد OTP عشوائي
            $expires_at = Carbon::now()->addMinutes(5);


            Mail::to($email)->send(new OtpEmail($otp));
            Cache::put('user_email', ["email" => $email], now()->addMinutes(15));
            Otp::updateOrCreate(
                ['email' => $email],  // تأكد من تمرير الإيميل بشكل صحيح
                [
                    'otp' => $otp,
                    'attempts' => 0,
                    'expires_at' => $expires_at
                ]
            );

             return RB::success(['otp' => $otp],200);
        } catch (ValidationException $e) {
           throw ValidationException::withMessages([
            'email' => ['The provided email are incorrect.'],
        ]);
        } catch (\Exception $e) {
          return RB::asError(500)
         ->withMessage($e->getMessage())
         ->build();
        }
    }


    public function validateOtp(ValidateOtpRequest $request)
    {
        try {
            $data = $request->validated();
            $cached_data = Cache::get("user_email");
            $emial = $cached_data['email'];
            $otp = Otp::getOtpByEmail($emial);

            if ($otp->attempts >= 3) {

                return response()->json([

                    'message' => 'Too many attempts. Try again later.',
                ]);
            }

            if ($otp->otp !== $data['otp']) {
                $otp->increment('attempts');
                $otp->save();


                return response()->json([

                    'message' => 'Invalid OTP.',
                ]);
            }

            $otp->attempts = 0;
            $otp->save();
           return RB::success([],200);
        } catch (ValidationException $e) {
            throw ValidationException::withMessages([
            'otp' => ['The provided otp are incorrect.'],
        ]);
        } catch (\Exception $e) {
             return RB::asError(500)
         ->withMessage($e->getMessage())
         ->build();
        }
    }
}
