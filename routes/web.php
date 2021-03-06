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
use App\Theory;
use App\TheoryAnswer;
use App\TheoryQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\People;
use App\TheoryUrl;

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
        $instructors = Instructor::with('times')->with('categories')->with('students')->get();
        $times = Time::with('instructors')->get();

        // return $times;

        return view('table.index', compact('instructors', 'times'));
    });
});

Route::prefix('/student')->group(function () {
    Route::get('/', function() {
        return redirect('/student/all');
    });
    Route::get('/create', 'StudentController@create_step_1_redirect');
    Route::get('/create/step-1', 'StudentController@create_step_1');
    Route::post('/create/step-1', 'StudentController@create_step_1_store');
    Route::get('/create/step-4/{id}', 'StudentController@create_step_2');
    Route::post('/create/step-4/{id}', 'StudentController@create_step_2_store');
    Route::get('/create/step-2/{id}', 'StudentController@create_step_3');
    Route::post('/create/step-2/{id}', 'StudentController@create_step_3_store');

    // --------------------------------------------- //
    
    Route::get('/all', 'StudentController@all');

    Route::get('/ongoing/{location_id}', 'StudentController@ongoing');
    Route::post('/assign-student', 'StudentController@assignStudent');

    Route::get('/delete/{id}', function($id) {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back();
    });
    
    // --------------------------------------------- //s

    Route::get('/edit/{id}', function($id) {
        $student = Student::findOrFail($id);
        $categories = Category::all();
        $locations = Location::all();
        $instructors = Instructor::all();

        return view('student.edit', compact('student', 'categories', 'locations', 'instructors'));
    });
    Route::post('/edit/{student}', function(Student $student, Request $request){
        $student->name = $request->name;
        $student->id_card = $request->idcardno;
        $student->phone = $request->phone;
        $student->p_address = $request->p_address;
        $student->c_address = $request->c_address;
        $student->dateofbirth = $request->dateofbirth;
        $student->gender = $request->gender;
        $student->license_no = $request->license_no;
        $student->rate = $request->rate;
        $student->discount = $request->discount;
        $student->instructor_id = $request->instructor_id;
        $student->time_id = $request->time_id;
        $student->location_id = $request->location_id;
        $student->save();
        
        // Old check

        // return $request->category;

        if ($request->category) {
            $oldCategories = $student->categories->pluck('id')->toArray();

            // dd($oldCategories);

            $removedCat = array_diff($oldCategories, $request->category);
            $addedCat = array_diff($request->category, $oldCategories);
            // dd($oldCategories, $removedCat, $addedCat);

            if ($removedCat) {
                foreach ($removedCat as $category) {
                    $student->categories()->detach($category);
                    $student->save();
                }
            }

            if ($addedCat) {
                foreach ($addedCat as $category) {
                    $student->categories()->attach($category);
                    $student->save();
                }
            }
        }


        return redirect()->back()->with('alert-success', 'Student info edited');
    });

    Route::get('refund/{student}', function(Student $student){
        return view('student.refund', compact('student'));
    });
    Route::post('refund/{student}', function(Student $student){
        $student->refunded = '1';
        $student->save();
        return redirect('/student/receipt/'. $student->id);
    });

    Route::get('end/{student}', function(Student $student){
        $student->finished_at = date("d/m/Y");
        $student->save();

        $slot = Slot::where('student_id', $student->id)->first();
        if ($slot !== NULL) {
            $slot->student_id = 0;
            $slot->isEmpty = 1;
            $slot->save();
        }

        return redirect()->back();
    });

    // --------------------------------------------- //

    Route::get('/fix-created-at', function() {
        // Run this code to fix created_at after playing student data in excel
        $students = Student::all();
        foreach ($students as $student) {
            // echo $student->created_at;
            $student->created_at = Carbon::createFromFormat('d-m-y G:i', $student->created_at_old)->toDateTimeString();
            $student->updated_at = Carbon::createFromFormat('d-m-y G:i', $student->updated_at_old)->toDateTimeString();
            $student->save();
        }
    });

    Route::get('from-site/new', function () {
        $students = TempStudent::all();
        return view('student.newView', compact('students'));
    });

    Route::get('fix-categories', function(){
        $students = Student::all();
        foreach ($students as $student) {
            $student->categories()->attach($student->category_id);
            $student->save();
        }
    });

    // --------------------------------------------- //

    Route::get('/receipt/{id}', function($id){
        $student = Student::where('id', $id)->with('categories')->with('slot')->with('slot.instructor')->with('location')->first();

        return view('student.receipt', compact('student'));
    });

    // --------------------------------------------- //

    Route::get('/theory/{id}', function($id){
        $student = Student::find($id);
        $theories = Theory::all();

        return view('theory.student', compact('student', 'theories'));
    });

    Route::post('/theory/{id}', function($id, Request $request){
        $student = Student::find($id);

        TheoryUrl::truncate();

        $url = new TheoryUrl;
        $url->url = $request->url;
        $url->save();

        return view('theory.testStarted', compact('student'));
    });

    Route::prefix('/theory')->group(function () {
        Route::get('{student_id}/practice/all/{id}', function ($student_id, $id) {
            $theory = Theory::where('id', $id)->with('questions')->with('questions.answers')->first();
            // return $theory;
            return view('theory.practice.all', compact('theory'));
        });
        Route::post('{student_id}/practice/all/{id}', function ($id, Request $request) {
            TheoryUrl::truncate();

            $array = $request->except(['_token']);
            $newArray = [];
            $result = [];

            $questionCount = '0';
            $correctCount = '0';
            foreach ($array as $key => $answer) {
                $questionCount++;
                $answerM = TheoryAnswer::find($answer);
                $answerC = TheoryAnswer::where('question_id', $key)->where('is_correct', '1')->first();
                
                $temp = array([
                    'question' => $key,
                    'answer' => $answer,
                    'isCorrect' => ($answerM->is_correct == '1' ? '1' : '0'),
                    'correct_answer' => $answerC
                ]);
                array_push($newArray, $temp);

                if ($answerM->is_correct == '1') {
                    $correctCount++;
                }
            }
            
            array_push($result, [
                'correct' => $correctCount,
                'total' => $questionCount,
                'percent' => round(($correctCount / $questionCount) * 100, 0) . '%'
            ]);

            return view('theory.result', compact('newArray', 'result'));
        });

        Route::get('{student_id}/practice/{id}/time', function ($student_id, $id) {
            $theory = Theory::where('id', $id)->with('questions')->with('questions.answers')->first();
            return view('theory.practice.time', compact('theory'));
        });
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
            
            return redirect('instructor');  
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
            ]);

            foreach ($request->category as $category) {
                \DB::table('category_instructor')->insert(
                    ['category_id' => $category, 'instructor_id' => $instructor->id]
                );
            }
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

        return redirect('/instructor');
    });
    Route::get('/categories-pivot', 'CategoryController@create_pivot_from_comma_table');

    Route::get('/delete/{instructor}', function(Instructor $instructor) {
        $slots = Slot::where('instructor_id', $instructor->id)->get();
        foreach ($slots as $slot) {
            $slot->delete();
        }
        $user = User::find($instructor->user_id);
        if ($user) {
            $user->delete();
        }
        $instructor->delete();

        return redirect()->back();
    });

    Route::get('/edit/{instructor}', function(Instructor $instructor) {
        $insCategories = $instructor->categories;
        $insSlots = $instructor->slots;
        $insTimes = $instructor->times;
        $categories = Category::all();
        $locations = Location::all();
        $times = Time::all();
        // return $insSlots;
        return view('instructor.edit', compact('instructor', 'insCategories', 'insSlots', 'insTimes', 'categories', 'locations', 'times'));
    });

    Route::post('/edit/{instructor}', function(Instructor $instructor, Request $request) {
        $instructor->location_id = $request->location_id;
        $instructor->name = $request->name;
        $instructor->idcardno = $request->idcardno;
        $instructor->phone = $request->phone;
        $instructor->p_address = $request->p_address;
        $instructor->c_address = $request->c_address;
        $instructor->dob = $request->dob;
        $instructor->gender = $request->gender;
        $instructor->license_no = $request->license_no;
        $instructor->license_expiry = $request->license_expiry;
        $instructor->save();

        if ($request->category) {
            $oldCategories = $instructor->categories->pluck('id')->toArray();

            $removedCat = array_diff($oldCategories, $request->category);
            $addedCat = array_diff($request->category, $oldCategories);

            if ($removedCat) {
                foreach ($removedCat as $category) {
                    \DB::table('category_instructor')->where('category_id', $category)->where('instructor_id', $instructor->id)->delete();
                }
            }

            if ($addedCat) {
                foreach ($addedCat as $category) {
                    \DB::table('category_instructor')->insert(
                        ['category_id' => $category, 'instructor_id' => $instructor->id]
                    );
                }
            }
        }

        if ($request->time) {
            $oldSlotsIDs = $instructor->times->pluck('times.id')->toArray();
            // dd($oldSlotsIDs);
            
            $removed = array_diff($oldSlotsIDs, $request->time);
            $added = array_diff($request->time, $oldSlotsIDs);

            // REMOVE THE OLD ONES
            if ($removed) {
                foreach ($removed as $remove) {
                    $instructor->times()->detach($remove);
                }
            }
            
            // ADD NEW ONES
            if ($added) {
                foreach ($added as $id) {
                    $instructor->times()->attach($id);
                }
                
            }
        }

        return redirect()->back();

    });
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

            $students = Student::where('finished_at', '=', null)->latest()->get();
            
            return view('transportfee.theory.index', compact('fees', 'type', 'students'));
        });

        Route::post('/post', function (Request $request) {
            // return $request;
            $student = Student::where('id', $request->student_id)->first();

            $fee = Transportfee::create([
                'student_id' => $student->id,
                'type' => 'theory',
                'paid' => $request->paid,
                'total' => $request->rate
            ]);

            if ($request->slipTaken == '1') {
                $fee->slipTaken = 1;
                $fee->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
                $fee->save();
            }
            
            $student->theory_count += 1;
            $student->save();
            
            return redirect('/transport-fee/theory');
        });

        Route::post('/addSlip', function (Request $request) {
            $slip = Transportfee::find($request->slip_id);

            $slip->paid = $request->paid;
            $slip->slipTaken = 1;
            $slip->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
            $slip->save();

            return redirect('/transport-fee/theory');
        });

        Route::get('/delete/{id}', function($id){
            $slip = Transportfee::findOrFail($id);
            $slip->delete();

            return redirect()->back();
        });
    });

    // ------------------------------- //
    Route::prefix('/driving')->group(function () {
        Route::get('/', function () {
            $fees = Transportfee::where('type', 'driving')->get();
            $type = 'Driving Fees';

            $students = Student::where('finished_at', '=', null)->latest()->get();

            return view('transportfee.driving.index', compact('fees', 'type', 'students'));
        });

        Route::post('/post', function (Request $request) {
            $student = Student::where('id', $request->student_id)->first();

            $fee = Transportfee::create([
                'student_id' => $student->id,
                'type' => 'driving',
                'paid' => $request->paid,
                'total' => $request->rate
            ]);

            if ($request->slipTaken == '1') {
                $fee->slipTaken = 1;

                if ($request->has('date')) {
                    $fee->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
                    $fee->save();
                }

                $fee->save();
            }

            $student->driving_count += 1;
            $student->save();
            
            return redirect('/transport-fee/driving');
        });

        Route::post('/addSlip', function (Request $request) {
            $slip = Transportfee::find($request->slip_id);

            $slip->paid = $request->paid;
            $slip->slipTaken = 1;
            $slip->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
            $slip->save();

            return redirect('/transport-fee/driving');
        });

        Route::get('/delete/{id}', function($id){
            $slip = Transportfee::findOrFail($id);
            $slip->delete();

            return redirect()->back();
        });
    });

    // ------------------------------- //
    Route::prefix('/license')->group(function () {
        Route::get('/', function () {
            $fees = Transportfee::where('type', 'license')->get();
            $type = 'Theory Fees';

            $students = Student::where('finished_at', '=', null)->latest()->get();
            
            return view('transportfee.license.index', compact('fees', 'type', 'students'));
        });

        Route::post('/post', function (Request $request) {
            $student = Student::where('id', $request->student_id)->first();

            $fee = Transportfee::create([
                'student_id' => $student->id,
                'type' => 'license',
                'paid' => $request->paid,
                'total' => $request->rate
            ]);

            if ($request->slipTaken == '1') {
                $fee->slipTaken = 1;
                $fee->save();

                if ($request->has('date')) {
                    $fee->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
                    $fee->save();
                }
            }

            return redirect('/transport-fee/license');
        });

        Route::post('/addSlip', function (Request $request) {
            $slip = Transportfee::find($request->slip_id);

            $slip->paid = $request->paid;
            $slip->slipTaken = 1;
            $slip->date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d H:i:s');
            $slip->save();

            return redirect('/transport-fee/license');
        });

        Route::get('/delete/{id}', function($id){
            $slip = Transportfee::findOrFail($id);
            $slip->delete();

            return redirect()->back();
        });
    });
});

Route::prefix('/users')->group(function () {
    Route::get('/', function () {
        $users = User::all();

        return view('user.index', compact('users'));
    });

    Route::get('/delete/{id}', function($id) {
        $user = User::findOrFail($id);
        $user->password = null;
        $user->save();

        return redirect()->back();
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

Route::get('/list/{start}/{end}', function ($start, $end){
    // dd($start, $end);
    $data = '';
    for ($i=$start; $i < $end; $i++) { 
$data .= 'A' . str_pad($i, 6, '0', STR_PAD_LEFT) . '
';
    }

    $my_file = "ids.txt";
    unlink($my_file);
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
    fwrite($handle, $data);
    fclose($handle);
});

Route::get('password/{password}', function($password){
    return Hash::make($password);
});

Route::get("/votes", function(){
    // jSON URL which should be requested
    $json_url = 'https://mvelection18.mihaaru.com/json/summary';

    $ch = curl_init( $json_url );

    // Configuring curl options
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
    );

    // Setting curl options
    curl_setopt_array( $ch, $options );

    // Getting results
    $results = curl_exec($ch); // Getting jSON result string

    $result = json_decode($results);

    // $json = Storage::disk('local')->get('votes.json');
    // $result = json_decode($json);

    $title = 'Vote';
    return view('vote', compact('result', 'title'));
});

Route::get('/update-dob/{s}/{f}', function($s, $f){
    $students = Student::findMany(range($s,$f));

    foreach ($students as $student) {
        $id_card = $student->id_card;
        $people = People::where('nid', $id_card)->first();
        if ($people !== NULL) {
            $student->dateofbirth = $people->dob;
            $student->save();
            echo "Done {$student->id}";
        }
    }
});

Route::prefix('/theory')->group(function () {
    Route::get('/', function () {
        return view('theory.index');
    });
    Route::get('/waiting', function (){
        return view('theory.waitingPage');
    });

    Route::prefix('/practice')->group(function () {
        Route::get('/{id}/all', function ($id) {
            $theory = Theory::where('id', $id)->with('questions')->with('questions.answers')->first();
            // return $theory;
            return view('theory.practice.all', compact('theory'));
        });

        Route::post('/{id}/all', function ($id, Request $request) {
            $array = $request->all();
            $newArray = [];
            $result = [];

            $questionCount = '0';
            $correctCount = '0';
            foreach ($array as $key => $answer) {
                $questionCount++;
                $answerM = TheoryAnswer::find($answer);
                $answerC = TheoryAnswer::where('question_id', $key)->where('is_correct', '1')->first();
                if ($answerM->is_correct == '1') {
                    $correctCount++;
                }
                $temp = array([
                    'question' => $key,
                    'answer' => $answer,
                    'isCorrect' => $answerM->is_correct,
                    'correct_answer' => $answerC
                ]);
                array_push($newArray, $temp);

                if ($answerM->is_correct == '1') {
                    $correctCount++;
                }
            }
            
            array_push($result, [
                'correct' => $correctCount,
                'total' => $questionCount,
                'percent' => round(($correctCount / $questionCount) * 100, 0) . '%'
            ]);

            return view('theory.result', compact('newArray', 'result'));
        });

        Route::get('/{id}/time', function ($id) {
            $theory = Theory::where('id', $id)->with('questions')->with('questions.answers')->first();
            return view('theory.practice.time', compact('theory'));
        });
    });

    Route::prefix('/manage')->group(function () {
        Route::get('/', function () {
           $theories = Theory::all();
            // return $theories;
           return view('theory.manage.index', compact('theories'));
        });
        Route::post('/add', function (Request $request) {
            $theory = new Theory;
            $theory->name = $request->name;
            if ($request->isDhivehi == '1') {
                $theory->isDhivehi = '1';
            }
            $theory->save();

            return redirect()->back();
        });
        Route::get('/delete/{id}', function($id) {
            $theory = Theory::findOrFail($id);
            $theory->delete();

            return redirect()->back();
        });

        Route::prefix('/questions')->group(function () {
            Route::get('{id}', function(Request $request) {
                $theory = Theory::findOrFail($request->id);

                return view('theory.manage.questions', compact('theory'));
            });

            Route::get('{id}/add-questions', function($id) {
                $theory = Theory::findOrFail($id);

                return view('theory.manage.addQuestion', compact('theory'));
            });
            Route::post('{id}/add-questions', function($id, Request $request) {
                $theory = Theory::findOrFail($id);
                $question = new TheoryQuestion;
                $question->theory_id = $id;
                $question->body = $request->question;
                $question->save();

                $answer1 =  new TheoryAnswer;
                $answer1->question_id = $question->id;
                $answer1->answer = $request->answer1;
                $answer1->is_correct = '1';
                $answer1->save();
        
                $answer2 =  new TheoryAnswer;
                $answer2->question_id = $question->id;
                $answer2->answer = $request->answer2;
                $answer2->is_correct = '1';
                $answer2->save();
                
                $answer3 =  new TheoryAnswer;
                $answer3->question_id = $question->id;
                $answer3->answer = $request->answer3;
                $answer3->is_correct = '1';
                $answer3->save();
                
                $answer4 =  new TheoryAnswer;
                $answer4->question_id = $question->id;
                $answer4->answer = $request->answer4;
                $answer4->is_correct = '1';
                $answer4->save();

                return redirect()->back()->with('alert-success', 'Question added');
            });

            Route::get('{id}/edit-questions/{question_id}', function($id, $question_id) {
                $theory = Theory::find($id);
                $question = TheoryQuestion::find($question_id);

                return view('theory.manage.editQuestion', compact('theory', 'question'));
            });
            Route::post('{id}/edit-questions/{$question_id}', function($id, $question_id, Request $request) {
                $theory = Theory::findOrFail($id);
                $question = new TheoryQuestion;
                $question->theory_id = $id;
                $question->body = $request->question;
                $question->save();

                $answer1 =  new TheoryAnswer;
                $answer1->question_id = $question->id;
                $answer1->answer = $request->answer1;
                $answer1->is_correct = '1';
                $answer1->save();
        
                $answer2 =  new TheoryAnswer;
                $answer2->question_id = $question->id;
                $answer2->answer = $request->answer2;
                $answer2->is_correct = '1';
                $answer2->save();
                
                $answer3 =  new TheoryAnswer;
                $answer3->question_id = $question->id;
                $answer3->answer = $request->answer3;
                $answer3->is_correct = '1';
                $answer3->save();
                
                $answer4 =  new TheoryAnswer;
                $answer4->question_id = $question->id;
                $answer4->answer = $request->answer4;
                $answer4->is_correct = '1';
                $answer4->save();

                return redirect()->back()->with('alert-success', 'Question added');
            });
        });
    });
});

Route::get('/password/{password}', function ($password) {
    return Hash::make($password);
});

Route::prefix('/reports')->group(function () {
    Route::get('/all', function () {
        $studentCounts = Student::where('year', '2019')->select(
            DB::raw('count(id) as sums'), 
            DB::raw("DATE_FORMAT(created_at,'%m') as months")
        )->groupBy('months')->get();

        return view('report.index', compact($studentCounts));
    });
});