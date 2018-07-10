<?php
use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use Illuminate\Http\Request;
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

    Route::get('/create', 'StudentController@create_step_1_redirect');

    Route::get('/create/step-1', 'StudentController@create_step_1');
    Route::post('/create/step-1', 'StudentController@create_step_1_store');

    Route::get('/create/step-2/{id}', 'StudentController@create_step_2');
    Route::post('/create/step-2/{id}', 'StudentController@create_step_2_store');

    Route::get('/create/step-3/{id}', 'StudentController@create_step_3');
    Route::post('/create/step-3/{id}', 'StudentController@create_step_3_store');
});

Route::get('/categories-pivot', 'CategoryController@create_pivot_from_comma_table');

Route::prefix('/table')->group(function () {
    Route::get('/', function () {
        $instructors = Instructor::with('slots')->with('categories')->get();
        $times = Time::with('slots')->with('slots.student')->with('slots.student.category')->get();

        return view('table.index', compact('instructors', 'times'));
    });
});