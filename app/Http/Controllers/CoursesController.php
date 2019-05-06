<?php
//©Alibek009
namespace App\Http\Controllers;
use DB;
use App\Course;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

class CoursesController extends Controller
{
    public function show($course_slug){
        $course = Course::where('slug',$course_slug)->with('publishedLessons')->firstOrFail();
        $purchased_courses = NULL;
        if(\Auth::check()){
            $purchased_courses = Course::whereHas('students',function($query){
                $query->where('id',\Auth::id());
            })->orderBy('id','desc')
                ->get();
        }

        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();
        return view('course',compact('course','purchased_courses','grades'));
    }

    public function grades(Request $request){
        $search = $request->get('grade');

        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();

        $courses = Course::where('grade',$search)->where('published',1)->get();
        return view('grades',compact('courses','grades','search'));
    }

    public function subjects(Request $request){
        $search = $request->get('grade');

        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();

        $courses = Course::where('grade',$search)->where('published',1)->get();
        return view('grades',compact('courses','grades','search'));
    }

    public function search(Request $request){
       $search = $request->get('search');

        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();
       $courses = Course::where('title','like','%'.$search.'%')->get();
       return view('search',compact('courses','grades'));
    }

    public function searchBySubject($subject){

        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();
        $courses = Course::where('title','like','%'.$subject.'%')->get();
        return view('searchBySubject',compact('courses','grades','subject'));
    }



    public function payment(Request $request){
        $course = Course::findOrFail($request->get('course_id'));
        $this->createStripeCharge($request);

        $course->students()->attach(\Auth::id());


        return redirect()->back->with('success','Payment completed successfully');
    }

    private function createStripeCharge($request)
    {
        Stripe::setApiKey(env('STRIPE_API_KEY'));
        try{
            $customer = Customer::create([
                'email'=>$request->get('stripeEmail'),
                'source'=>$request->get('stripeToken')
            ]);

            $charge = Charge::create([

                'customer'=>$customer->id,
                'amount'=>$request->get('amount'),
                'currency'=>'kzt'
            ]);
        }catch (\Stripe\Error\Base $e){

            return redirect()->back()->withError($e)->send();

        }
    }

    public function rating($course_id, Request $request){
        $course = Course::findOrFail($course_id);

        $course->students()->updateExistingPivot(\Auth::id(),['rating'=>$request->get('rating')]);

        return redirect()->back()->with('success','Thank you for feedback!');
    }

}
