<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
       //validate data

       //find user by email
       $user=User::where('email',$request->email)->first();
       //check if user is present and password is correct
       if (! ($user || Hash::check($request->password, $user->password))) {
        return $this->error('not correct data',['data'=>'data is not correct']);
       }
       //check user is validate
       if (is_null($user->email_verified_at)) {
        return $this->error('not verified',['data'=>'user is not verified']);
       }
       //crete token and return data with token
       $token= 'Bearer '.$user->createToken($request->device_name)->plainTextToken;
       $user->token=$token;
       return $this->data(compact('user'));

    }





    //logout
    //1 logout from all devices
    public function logoutall(Request $request)
    {
        //delete all tokens
        $request->user('sanctum')->tokens()->delete();
        return $this->success('successfull operation');


    }
//logout from current device
    public function logoutcurrent(Request $request)
    {
       $request->user('sanctum')->CurrentAccessToken()->delete();
       return $this->success('successfull operation');
    }
//logout from other device
    public function logoutother(Request $request)
    {
        //tokenid
        // cut token
        $array=explode('|',$request->header('Authorization'));
        $tokenid = explode(' ',$array[0])[1];
        $request->user('sanctum')->tokens()->where('id', $tokenid )->delete();
        return $this->success('successfull operation');
    }

}
