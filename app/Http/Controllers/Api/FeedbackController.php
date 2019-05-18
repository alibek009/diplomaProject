<?php
//©Alibek009
namespace App\Http\Controllers\Api;

use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class FeedbackController extends Controller
{
    public $successStatus = 200;

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>!$validator->errors()], 401);
        }
        $input = $request->all();
        $message = Feedback::create([
            'email' => $input['email'],
            'message' => $input['message']
        ]);
        return response()->json(['success'=>true], $this-> successStatus);
    }
}
