<?php

namespace App\Http\Controllers\Api\Mobile\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
    try {
    $data=$request->validated();
    $data['password'] = bcrypt($data['password']);
    $user=User::create($data);

 return RB::success(['user' => $user],200);

        } catch (\Exception $e) {
   return RB::asError(500)
         ->withMessage($e->getMessage())
         ->build();
}
    }


    public function login(AuthRequest $request)
    {
        try {

            $user = User::getUserByEmail($request->email);
            if (! $user || ! Hash::check($request->password, $user->password)) {
             throw ValidationException::withMessages([
            'credentials' => ['The provided credentials are incorrect.'],
        ]);
            }


            // Create token
            $token = $user->createToken($request->email)->plainTextToken;

 return RB::success(['token' => $token],200);


        } catch (\Exception $e) {
return RB::asError(500)
         ->withMessage($e->getMessage())
         ->build();
        }
    }

    public function logout(Request $request){

        try {
            // حذف التوكن الحالي
            $request->user()->currentAccessToken()->delete();

            return RB::success(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return RB::asError(500)
                ->withMessage($e->getMessage())
                ->build();
        }
    }

    }

