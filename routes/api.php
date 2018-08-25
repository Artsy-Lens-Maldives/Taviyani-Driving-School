<?php

use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use App\Transportfee;
use App\TempStudent;
use Illuminate\Http\Request;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/categories', function() {
    return Category::all();
});

Route::get('/category-instructor/{category_id}/{location_id}', function($category_id, $location_id) {
    return Instructor::where('location_id', $location_id)->get();
    return Instructor::where('location_id', $location_id)->whereHas('category', function($q) {
        $q->where('id', $category_id);
    })->get();
});

Route::get('/instructor/free-times/{id}', function($id) {
    $slots = Slot::where('isEmpty', '1')->where('instructor_id', $id)->with('time')->get();
    
    return $slots;
});

Route::get('/free-times/{id}', function($id) {
    $slots = Slot::where('isEmpty', '1')->where('instructor_id', $id)->with('time')->get();
    
    foreach ($slots as $slot) {
        echo "<option value='". $slot->time->id ."'>". $slot->time->time ."</option>";
    }
});

Route::get('/student/names', function(){
    return Student::pluck('name');
});

Route::get('/slip-info/{id}', function($id){
    return Transportfee::where('id', $id)->with('student')->first();
});

Route::get('/student/post', function(Request $request) {
    $student = TempStudent::create([
        'name' => $request->name,
        'id_card' => $request->idcardno,
        'phone' => $request->phone,
        'p_address' => $request->p_address,
        'c_address' => $request->c_address,
        'dateofbirth' => $request->dateofbirth,
        'gender' => $request->gender,
        'category_id' => $request->category_id,
        'location_id' => $request->location_id
    ]);
    
    $student_id = $student->id;
    $category_id = $student->category_id;
    $location_id = $student->location_id;

    return redirect("//127.0.0.1:8000/form/step-2/{$student_id}/{$location_id}/{$category_id}");
});

Route::post('/student/step-2/post', function(Request $request) {
    $student = TempStudent::findOrFail($request->student_id);
    $student->instructor_id = $request->instructor_id;
    $student->time_id = $request->time_id;
    $student->save();

    return $student;
});