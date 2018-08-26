<?php
use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use App\Transportfee;
use App\TempStudent;
use App\User;
use App\Vehicle;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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


Route::prefix('/table')->group(function () {
    Route::get('/', function () {
        $instructors = Instructor::with('slots')->with('categories')->get();
        $times = Time::with('slots')->with('slots.student')->with('slots.student.category')->get();

        return view('table.index', compact('instructors', 'times'));
    });
});

Route::prefix('/student')->group(function () {
    Route::get('/', 'StudentController@index');

    Route::post('/assign-student', 'StudentController@assignStudent');

    Route::get('/create', 'StudentController@create_step_1_redirect');

    Route::get('/create/step-1', 'StudentController@create_step_1');
    Route::post('/create/step-1', 'StudentController@create_step_1_store');

    Route::get('/create/step-4/{id}', 'StudentController@create_step_2');
    Route::post('/create/step-4/{id}', 'StudentController@create_step_2_store');

    Route::get('/create/step-2/{id}', 'StudentController@create_step_3');
    Route::post('/create/step-2/{id}', 'StudentController@create_step_3_store');

    Route::get('/fix-created-at', function() {
        // Run this code to fix created_at after playing with it in excel

        $students = Student::all();

        foreach ($students as $student) {
            // echo $student->created_at;
            $student->created_at = Carbon::createFromFormat('d-m-y G:i', $student->created_at_old)->toDateTimeString();
            $student->updated_at = Carbon::createFromFormat('d-m-y G:i', $student->updated_at_old)->toDateTimeString();
            $student->save();
        }
    });

    Route::get('new', function () {
        $students = TempStudent::all();
        return view('student.newView', compact('students'));
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
        $locations = Location::all();
        $times = Time::all();
        return view('instructor.create', compact('categories', 'locations', 'times'));
    });

    Route::post('create', function (Request $request){
        // TODO: Fill this

        // dd($request->category);
        if ($request->category) {
            $arr = $request->category;
            $str = implode(",", $arr);
        }

        try {
            $instructor = Instructor::create([
                'location_id' => $request->location_id,
                'name' => $request->first_name . " " . $request->last_name,
                'idcardno' => $request->idcardno,
                'phone' => $request->phone,
                'p_address' => $request->p_address,
                'c_address' => $request->c_address,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'license_no' => $request->license_no,
                'license_expiry' => $request->license_expiry,
                'category' => $str,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('alert-danger', $e->getMessage());
        }

        try {
            $user = User::create([
                'name' => $instructor->name,
                'email' => $request->email,
                'password' => Hash::make($request->pass)
            ]);
        } catch (\Exception $e) {
            $instructor->delete();
            return redirect()->back()->withInput()->with('alert-danger', $e->getMessage());
        }
        
        $user->assignRole('instructor');
        $user->save();

        $instructor->user_id = $user->id;
        $instructor->save();

        // Slot creation
        if ($request->time) {
            $arr1 = $request->time;

            foreach ($arr1 as $id) {
                $checkSlot = Slot::where('instructor_id', $instructor->id)->where('time_id', $id)->first();
    
                if ($checkSlot == null) {
                    $slot = new Slot;
                    $slot->instructor_id = $instructor->id;
                    $slot->time_id = $id;
                    $slot->save();
                }
            }
        }

        return redirect('/instructor/categories-pivot');
    });
    Route::get('/categories-pivot', 'CategoryController@create_pivot_from_comma_table');
});


Route::prefix('/vehicle')->group(function () {
    Route::get('/', function () {
        $vehicles = Vehicle::all();
        return view('vehicle.view', compact('vehicles'));
    });

    Route::get('/create', function () {
        $categories  = Category::all();
        return view('vehicle.create', compact('categories'));
    });

    Route::post('/create', function (Request $request) {
        $vehicle = Vehicle::create([
            'number' => $request->number,
            'category_id' => $request->category
        ]);
        return redirect('vehicle');
    });
});

Route::prefix('/category')->group(function () {
    Route::get('/', function () {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    });

    Route::get('/create', function () {
        return view('category.create');
    });

    Route::post('/create', function (Request $request) {
        $category = Category::create([
           'name' => $request->name,
            'code' => $request->code,
            'rate' => $request->rate,
        ]);
        return redirect('/category');
    });

    Route::get('/edit/{id}', function ($id) {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    });

    Route::post('/edit/{id}', function ($id, Request $request) {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->code = $request->code;
        $category->rate = $request->rate;
        $category->save();
        return redirect('/category');
    });

    Route::get('/delete/{id}', function($id) {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/category');
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
        $user->syncRoles($request->role);
        $user->save();

        return redirect('/users');
    });
});
