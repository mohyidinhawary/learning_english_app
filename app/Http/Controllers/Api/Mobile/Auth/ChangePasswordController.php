<?php

namespace App\Http\Controllers\Api\Mobile\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;

class ChangePasswordController extends Controller
{
    public function ChnagePassword(ChangePasswordRequest $request)
    {
        try {
            $password = $request->validated()['password'];
            $cached_data = Cache::get("user_email");
            $email = $cached_data['email'];
            $user = User::getUserByEmail($email);
            if ($user) {
                $user->update([
                    "password" => Hash::make($password),

                ]);
                return RB::success(['new password' => $password],200);
            }
        } catch (ValidationException $e) {
           throw ValidationException::withMessages([
            'password' => ['password must contain at lest 8 char one of them number and contain small and capital letters '],
        ]);
        } catch (\Exception $e) {
          return RB::asError(500)
         ->withMessage($e->getMessage())
         ->build();
        }
    }
}
