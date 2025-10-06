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
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Auth as FirebaseAuth;

class AuthController extends Controller
{

    //  protected $auth;

    // public function __construct(FirebaseAuth $auth)
    // {
    //     $this->auth = $auth;
    // }

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



    // public function loginWithFirebase(Request $request)
    // {
    //     $idToken = $request->bearerToken(); // أو $request->input('idToken')

    //     try {
    //         $verifiedIdToken = $this->auth->verifyIdToken($idToken);
    //         $uid = $verifiedIdToken->claims()->get('sub');

    //         // هون بتجيب بيانات اليوزر من Firebase أو تخزنه بجدول users
    //         $firebaseUser = $this->auth->getUser($uid);

    //         $user = User::firstOrCreate(
    //             ['firebase_uid' => $uid],
    //             ['email' => $firebaseUser->email]
    //         );

    //         // رجع JWT/Laravel token عادي
    //         $token = $user->createToken('api')->plainTextToken;

    //         return response()->json(['token' => $token]);
    //     } catch (ValidationException $e) {
    //         return response()->json(['error' => 'Invalid Firebase token'], 401);
    //     }
    // }

    }

