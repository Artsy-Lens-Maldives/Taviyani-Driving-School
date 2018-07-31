<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('category')->with('slot')->with('slot.instructor')->get();
        $instructors = Instructor::all();
        // return $students;
        return view('student.view', compact('students', 'instructors'));
    }

    public function create_step_1_redirect()
    {
        return redirect('/student/create/step-1');
    }

    public function create_step_1()
    {
        return view('student.create');
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
            'license_no' => $request->license_no
        ]);

        $url = 'student/create/step-2/'.$student->id;
        return redirect($url);
    }

    public function create_step_2($id)
    {
        $student = Student::findOrFail($id);
        $categories = Category::all();
        return view('student.create-2', compact('student', 'categories'));
    }

    public function create_step_2_store($id, Request $request)
    {
        // dd($request->category);

        $student = Student::findOrFail($id);
        $student->category_id = $request->category;
        $student->save();

        $url = 'student/create/step-3/'.$student->id;
        return redirect($url);
    }

    public function create_step_3($id)
    {
        $student = Student::findOrFail($id);
        $category = Category::find($student->category_id);
        $instructors = $category->instructors;

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
}
