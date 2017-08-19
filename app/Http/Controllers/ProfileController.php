<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends Controller
{
    protected $token;

    public function __construct(Profile $profile)

    {
        $this->token = JWTAuth::parseToken()->authenticate();
        $this->profile = $profile;
    }


    public function index()
    {
        $id   = $this->token->user_id;
        $get  = Profile::find($id);
        return response()->json(['data'=>$get]);
    }

   
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
        $id   = $this->token->user_id;
        $response = $this->profile->changePassword($request,$id);
        return response()->json($response);
    }

   

   
    public function update(Request $request)
    {
        $id   = $this->token->user_id;

        $type = $request['type'];

        if($type === 'username')
        {

            $response = $this->profile->changeUsername($request['username'],$id);

        }
        
        else if($type === 'profileName')
        {
            $response = $this->profile->changeProfileName($request['profile_name'],$id);
        }

        return response()->json($response);

    }



}
