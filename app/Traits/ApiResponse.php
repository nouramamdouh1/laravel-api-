<?php
namespace App\Traits;

trait ApiResponse{
    //3 methods

    public function success(string $message,int $statuscode=200)
    {
        return response()->json([
            //4
            'success'=>true,
            'message'=>$message,
            'data'=>(object)[],
            'errors'=>(object)[]
        ],$statuscode);
    }


    public function error(string $message,array $errors,int $statuscode=400)
    {
        return response()->json([
            //4
            'success'=>false,
            'message'=>$message,
            'data'=>(object)[],
            'errors'=>$errors
        ],$statuscode);
    }



    public function data(array $data,int $statuscode=200)
    {
        return response()->json([
            //4
            'success'=>true,
            'message'=>'',
            'data'=>$data,
            'errors'=>(object)[]
        ],$statuscode);
    }




}









