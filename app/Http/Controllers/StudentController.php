<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use App\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function all(Request $request)
    {
        if ($request->exists('startDate') AND $request->exists('endDate')) {
            $fromDate = date_create_from_format('d/m/Y', $request->startDate);
            $from = date_format($fromDate, 'Y-m-d h:m:s');

            $toDate = date_create_from_format('d/m/Y', $request->endDate);
            $to = date_format($toDate, 'Y-m-d 23:59:59');

            $students = Student::whereBetween('created_at', [$from, $to])->with('category')->with('slot')->with('slot.instructor')->with('location')->get();
        } else {
            $students = Student::with('category')->with('slot')->with('slot.instructor')->with('location')->get();
        }
        $instructors = Instructor::all();
        $location = null;
        
        return view('student.view', compact('students', 'instructors', 'location'));
    }

    public function ongoing($location_id, Request $request)
    {
        if ($request->exists('startDate') AND $request->exists('endDate')) {
            $fromDate = date_create_from_format('d/m/Y', $request->startDate);
            $from = date_format($fromDate, 'Y-m-d h:m:s');

            $toDate = date_create_from_format('d/m/Y', $request->endDate);
            $to = date_format($toDate, 'Y-m-d  23:59:59');

            $students = Student::where('refunded', '0')->where('location_id', $location_id)->where('finished_at', '=', null)->whereBetween('created_at', [$from, $to])->with('category')->with('slot')->with('slot.instructor')->with('location')->get();
        } else {
            $students = Student::where('refunded', '0')->with('category')->with('slot')->with('slot.instructor')->with('location')->where('location_id', $location_id)->where('finished_at', '=', null)->get();
        }
        
        $instructors = Instructor::all();
        // return $students;
        $location = Location::find($location_id);
        return view('student.view', compact('students', 'instructors', 'location'));
    }

    public function create_step_1_redirect()
    {
        return redirect('/student/create/step-1');
    }

    public function create_step_1()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('student.create', compact('categories', 'locations'));
    }

    public function create_step_1_store(Request $request)
    {
        $student = Student::firstOrCreate([
            'name' => $request->name,
            'id_card' => 'A'.$request->idcardno,
            'phone' => $request->phone,
            'p_address' => $request->p_address,
            'c_address' => $request->c_address,
            'dateofbirth' => $request->dateofbirth,
            'gender' => $request->gender,
            'license_no' => $request->license_no,
            'category_id' => $request->category,
            'location_id' => $request->location_id,
            'user_id' => \Auth::user()->id,
            'rate' => $request->rate,
            'discount' =>$request->discount
        ]);

        $url = 'student/create/step-2/'.$student->id;
        return redirect($url);
    }
    
    public function create_step_3($id)
    {
        $student = Student::findOrFail($id);
        $instructors = Category::find($student->category_id)->instructors()->where('location_id', $student->location_id)->get();
        
        return view('student.create-3', compact('student', 'instructors'));
    }

    public function create_step_3_store($id, Request $request)
    {
        $student = Student::findOrFail($id);
        $category = Category::find($student->category_id);
        $instructors = $category->instructors;

        $slot = Slot::where('time_id', $request->time)->where('instructor_id', $request->instructor)->first();
        $slot->student_id = $student->id;
        $slot->isEmpty = '0';
        $slot->save();

        return redirect('/');
    }

    public function assignStudent(Request $request) {
        // $instructor = Instructor::findOrFail($request->instructor_id);
        // $student = Student::findOrFail($request->student_id);
        // $time = Time::findOrFail($request->time);

        $slot = Slot::where('instructor_id', $request->instructor_id)
                      ->where('time_id', $request->time_id)
                      ->where('IsEmpty', '1')
                      ->first();

        // return $slot;

        if ($slot !== null) {
            $slot->student_id = $request->student_id;
            $slot->isEmpty = '0';
            $slot->save();
            return redirect('table');
        } else {
            return redirect('student');
        }
    }
}
