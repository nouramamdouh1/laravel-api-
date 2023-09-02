<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    use ApiResponse;
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request)
    {
        //validate
        //hash password
        $password=Hash::make($request->password);
        //save data in database
        $data=$request->validated();
        $data['password']=$password;
        $user=User::create($data);
        //make token
        $token= 'Bearer '.$user->createToken($request->device_name)->plainTextToken;
         //return token with data
        $user->token=$token;
        //return response
        return $this->data(compact('user'));


    }
}
