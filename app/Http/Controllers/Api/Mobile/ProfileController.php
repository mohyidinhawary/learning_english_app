<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use App\Http\Resources\ProfileResource;
use App\Models\User;
class ProfileController extends Controller
{
    public function profile(){
        try{
       $user = auth()->user();
          return RB::success(['profile details' =>new ProfileResource($user)],200);

    }catch (\Exception $e) {
          return RB::asError(500)
         ->withMessage($e->getMessage())
         ->build();
        }
}

public function deleteaccount(){
    try{
       $userid = auth()->user()->id;
       $account=User::Where("id",$userid)->delete();
          return RB::success(['account  deleted' =>$account],200);

    }catch (\Exception $e) {
          return RB::asError(500)
         ->withMessage($e->getMessage())
         ->build();
        }
}
}
