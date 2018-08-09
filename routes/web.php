<?php
use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use App\Transportfee;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('/slot')->group(function () {
    Route::get('/', 'SlotController@index');

    Route::get('/create', 'SlotController@reset_slots');

    Route::get('/{instructor_id}', 'SlotController@get_instructors_slots');
    
    Route::get('/switch/{id}/{new_id}/{student_id}', 'SlotController@switch_students_slot');
});

Route::prefix('/student')->group(function () {
    Route::get('/', 'StudentController@index');

    Route::post('/assign-student', function(Request $request) {
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

    });

    Route::get('/create', 'StudentController@create_step_1_redirect');

    Route::get('/create/step-1', 'StudentController@create_step_1');
    Route::post('/create/step-1', 'StudentController@create_step_1_store');

    Route::get('/create/step-2/{id}', 'StudentController@create_step_2');
    Route::post('/create/step-2/{id}', 'StudentController@create_step_2_store');

    Route::get('/create/step-3/{id}', 'StudentController@create_step_3');
    Route::post('/create/step-3/{id}', 'StudentController@create_step_3_store');

    Route::get('/fix-created-at', function() {
        $students = Student::all();

        foreach ($students as $student) {
            // echo $student->created_at;
            $student->created_at = Carbon::createFromFormat('d-m-y G:i', $student->created_at_old)->toDateTimeString();
            $student->updated_at = Carbon::createFromFormat('d-m-y G:i', $student->updated_at_old)->toDateTimeString();
            $student->save();
        }
    });
});

Route::prefix('/instructor')->group(function (){
    Route::get('/', function() {
        $instructors = Instructor::with('categories')->withCount('categories')->get();
        $students = Student::get();

        $students->filter(function ($value, $key) {
            $student_ids = Slot::where('student_id', '!=', '0')->pluck('student_id')->toArray();

            foreach ($student_ids as $id) {
                if ($id !== $value) {
                    return $value;
                }
            }
        });

        return view('instructor.view', compact('instructors', 'students'));
    });

    Route::post('/assign-student', function(Request $request) {
        // $instructor = Instructor::findOrFail($request->instructor_id);
        // $student = Student::findOrFail($request->student);
        // $time = Time::findOrFail($request->time);

        $slot = Slot::where('instructor_id', $request->instructor_id)
                      ->where('time_id', $request->time_id)
                      ->where('IsEmpty', '1')
                      ->first();

        if ($slot !== null) {
            $slot->student_id = $request->student_id;
            $slot->isEmpty = '0';
            $slot->save();
            return redirect('table');
        } else {
            return redirect('instructor');
        }

    });

    Route::get('create', function (){
        $categories = Category::all();
        return view('instructor.create', compact('categories'));
    });
});

Route::get('/categories-pivot', 'CategoryController@create_pivot_from_comma_table');

Route::prefix('/table')->group(function () {
    Route::get('/', function () {
        $instructors = Instructor::with('slots')->with('categories')->get();
        $times = Time::with('slots')->with('slots.student')->with('slots.student.category')->get();

        return view('table.index', compact('instructors', 'times'));
    });
});

Route::prefix('/transport-fee')->group(function () {
    Route::prefix('/theory')->group(function () {
        Route::get('/', function () {
            $fees = Transportfee::where('type', 'theory')->with('student')->get();
            $type = 'Theory Fees';

            $students = Student::all();
            
            return view('transportfee.theory.index', compact('fees', 'type', 'students'));
        });

        Route::post('/post', function (Request $request) {
            // return $request;
            $student = Student::where('name', $request->student)->first();

            $fee = Transportfee::create([
                'student_id' => $student->id,
                'type' => 'theory',
                'paid' => $request->paid,
                'total' => $request->rate
            ]);

            if ($request->slipTaken == '1') {
                $fee->slipTaken = 1;
                $fee->save();
            }

            if ($request->has('date')) {
                $fee->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
                $fee->save();
            }

            $student->theory_count += 1;
            $student->save();
            
            return redirect('/transport-fee/theory');
        });
    });

    // ------------------------------- //
    Route::prefix('/driving')->group(function () {
        Route::get('/', function () {
            $fees = Transportfee::where('type', 'driving')->get();
            $type = 'Theory Fees';

            $students = Student::all();
            return view('transportfee.driving.index', compact('fees'));
        });

        Route::post('/post', function (Request $request) {
            // return $request;
            $student = Student::where('name', $request->student)->first();

            $fee = Transportfee::create([
                'student_id' => $student->id,
                'type' => 'driving',
                'paid' => $request->paid,
                'total' => $request->rate
            ]);

            if ($request->slipTaken == '1') {
                $fee->slipTaken = 1;
                $fee->save();
            }

            if ($request->has('date')) {
                $fee->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
                $fee->save();
            }

            $student->driving_count += 1;
            $student->save();
            
            return redirect('/transport-fee/driving');
        });
    });

    // ------------------------------- //
    Route::prefix('/license')->group(function () {
        Route::get('/', function () {
            $fees = Transportfee::where('type', 'license')->get();
            $type = 'Theory Fees';

            $students = Student::all();
            return view('transportfee.license.index', compact('fees'));
        });

        Route::post('/post', function (Request $request) {
            // return $request;
            $student = Student::where('name', $request->student)->first();

            $fee = Transportfee::create([
                'student_id' => $student->id,
                'type' => 'license',
                'paid' => $request->paid,
                'total' => $request->rate
            ]);

            if ($request->slipTaken == '1') {
                $fee->slipTaken = 1;
                $fee->save();
            }
            
            if ($request->has('date')) {
                $fee->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
                $fee->save();
            }
            
            return redirect('/transport-fee/license');
        });
    });
});

Route::prefix('/users')->group(function () {
    Route::get('/', function () {
        $users = User::all();

        return view('user.index', compact('users'));
    });

    Route::get('create-roles', function() {
        $role = Role::create([
            'name' => 'student',
            'name' => 'instructor',
            'name' => 'admin'
        ]);
    });

    Route::post('/assign-role', function (Request $request) {
        $user = User::findOrFail($request->user_id);
        $user->assignRole($request->role);
        $user->save();

        return redirect('/users');
    });
});
