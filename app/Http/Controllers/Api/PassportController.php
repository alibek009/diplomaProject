<?php
//©Alibek009
namespace App\Http\Controllers\Api;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email'=>request('email'),'password'=>request('password')])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success'=>$success],$this->successStatus);
        }
        else{

            return response()->json(['error'=>'Unauthorized'],401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>!$validator->errors()], 401);
        }
        $checkUser = User::where('email' , $request['email'])->get()->first();
        if($checkUser){
            return response()->json(['success'=>false, 'message' => 'user with this email already exists']);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create([
            'password' => $input['password'],
            'email' => $input['email'],
            'name' => $input['name']
        ]);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        $profile = Profile::create([
            'user_id' => $user->id,
            'avatar' => 'uploads/avatars/default_avatar.jpg',
        ]);
        return response()->json(['success'=>$success], $this-> successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }


}
