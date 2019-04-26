<?php

namespace App\Http\Controllers\Api;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{


    public function detail($id){
        $user = User::findOrFail($id);
        return response()->json($user);
    }


}
