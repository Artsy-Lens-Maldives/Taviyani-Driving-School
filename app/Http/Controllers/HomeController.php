<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Transportfee;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->student_id) {
            $student = Student::find($request->student_id);
            $theory = Transportfee::where('student_id', $request->student_id)->where('type', 'theory')->orderBy('created_at', 'ASC')->get();
            $driving = Transportfee::where('student_id', $request->student_id)->where('type', 'driving')->orderBy('created_at', 'ASC')->get();
    
            return view('home', compact('student', 'theory', 'driving'));
        } else {
            $students = Student::all();
            return view('home', compact('students'));
        }
    }
}
