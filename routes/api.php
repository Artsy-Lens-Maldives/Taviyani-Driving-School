<?php

use Illuminate\Http\Request;
use App\Category;
use App\Time;
use App\Instructor;
use App\Slot;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories', function() {
    return Category::all();
});

Route::get('/category-instructor/{id}', function($id) {
    return Category::where('id', $id)->with('instructors')->first();
});

Route::get('/free-times/{id}', function($id) {
    $slots = Slot::where('isEmpty', '1')->where('instructor_id', $id)->with('time')->get();
    
    foreach ($slots as $slot) {
        echo "<option value='". $slot->time->id ."'>". $slot->time->time ."</option>";
    }
});