<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Notifications\appcode;
use Illuminate\Notifications\Notification;

class VerifictionController extends Controller
{
    use ApiResponse;
    public function send(Request $request)
    {

        //get user
        $user = $request->user('sanctum');
        //get token
        $token = $request->header('Authorization');
        //make code
        $verifcation_code = rand(100000, 999999);
        //save code in database
        $user->verifcation_code = $verifcation_code;
        $user->save();
        //mail
        Notification::send($user,new appcode($verifcation_code));
        //return token
        $user->token = $token;
        //return response
        return $this->data(compact('user'));
    }


    public function verify (Request $request)
    {
      //validate on coming code
      $request->validate([
        'verifcation_code'=>['required','integer','digits:6','exists:users']
      ]);
      //know user and its token
      $user=$request->user('sanctum');
      $token=$request->header('Authorization');
      //check if code in database=code user send
      if ($user->verifcation_code==$request->verifcation_code) {
       //verify him
       $user->email_verified_at= date('Y-m-d H:i:s');
       $user->save();
       $user->token=$token;
       //return response with token
       return $this->data(compact('user'));
      }
      //return error response
      return $this->error('invalid code',['code'=>'error in code']);


    }
}
