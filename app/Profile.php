<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
class Profile extends Model
{
    protected $table = 'tblusers';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'profile_name', 
        'username', 
        'password', 
        'role', 
        'img_profile',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function changeUsername($data,$id)

    {

        $check = $this::where('username','=',$data)->count();
        if($check==0)
        {
            $user['username'] = $data;
            $this::where('user_id','=',$id)->update($user);
            $response = ['status' => 200];
        }
        else
        {
            $response = ['status' => 403];
        }

        return $response;
    }

    public function changeProfileName($data,$id)

    {
        $user = ['profile_name' => $data];
        $this::where('user_id','=',$id)->update($user);
        $response = ['status' => 200];
        return $response;
    }

    public function changePassword($request,$id)

    {
        $get = $this::where('user_id','=',$id)->first();
        $hashedPassword = $get->password;
        if (Hash::check($request->current_password, $hashedPassword)) {
            $data = ['password' => bcrypt($request->new_password)];
            $this::where('user_id','=',$id)->update($data);
            $response = ['status' => 200];
        }

        else
        {
            $response = ['status' => 403];
        }


        return $response;

    }
}
