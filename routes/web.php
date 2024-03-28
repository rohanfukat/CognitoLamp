<?php

use Illuminate\Http\Request;
use Illuminate\Support\Fascades\Http;
use Illuminate\Support\Facades\Route;


Route::get('/', function (Request $request) {
    $grantCode = $request->get('code');
    $response = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'Authorization'=>'Basic YWlrOWo4dHZzcXRxdDY2cTBvaTdrczQ2aToxdGJjczZvYmRhY3AwcmJxaHI4bnJmczB1Y2gwbzJtM3BvazhpZHEyZHNwNnByMWU5cTRn'  
    ])->withOptions(['verify'=>false])->post('https://localmachine.auth.ap-south-1.amazoncognito.com/oauth2/token',[
        'grant_type' => 'authorization_code',
        'code'=>$grantCode,
        // 'redirect_uri'=>'http://localhost:8000'
        'redirect_uri'=>'http://43.205.39.114'
    ]);
 
    $decodedResponse = json_decode($response);
    $access_token = $decodedResponse->access_token;
    // dd($access_token);
    $userInfoResponse = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'Authorization'=>'Bearer '.$access_token
    ])->withOptions(['verify'=>false])->get('https://localmachine.auth.ap-south-1.amazoncognito.com/oauth2/userInfo');
    $data = json_decode($userInfoResponse);

    return view('index',['data'=>$data]);
});

