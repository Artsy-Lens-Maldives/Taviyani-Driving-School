<?php

use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use App\Transportfee;
use App\TempStudent;
use App\TheoryUrl;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\People;

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

Route::get('/category/rate/', function(Request $request) {
    $category = Category::where('code', $request->code)->first();
    return $category->rate;
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
    $instructor = Instructor::where('id', $id)->with('times')->first();
    
    foreach ($instructor->times as $time) {
        echo "<option value='". $time->id ."'>". $time->time ."</option>";
    }
});

Route::get('/student/names', function(){
    return Student::where('finished_at', '=', null)->latest()->pluck('name', 'id_card');
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

    // return $student;

    if (App::environment('local')) {
        return redirect("//taviyani.test.mv/driving-school/form/step-2/{$student_id}/{$location_id}/{$category_id}");
    } else {
        return redirect("//taviyani.com.mv/driving-school/form/step-2/{$student_id}/{$location_id}/{$category_id}");
    }
});

Route::get('/student/step-2/post', function(Request $request) {
    $student = TempStudent::findOrFail($request->student_id);
    $student->instructor_id = $request->instructor_id;
    $student->time_id = $request->time_id;
    $student->save();

    if (App::environment('local')) {
        return redirect("//taviyani.test.mv/driving-school/success");
    } else {
        return redirect("//taviyani.com.mv/driving-school/success");
    }
});

Route::get('/{type}/table/{id}', function($type, $id) {
    $theory = Transportfee::where('student_id', $id)->where('type', $type)->orderBy('created_at', 'ASC')->get();

    if ($theory->count() > 0) {
        $table = "";
        $i = 1;
        foreach ($theory as $t) {
            $remaining = $t->total - $t->paid;

            $table .= "
            <tr>
                <td>{$i}</td>
                <td>{$t->paid}</td>
                <td>{$remaining}</td>
            ";
            if ($t->slipTaken == 0 ) {
                $table .= "<td>No</td>";
                $table .= "<td>-</td>";
                $table .= "<td>-</td>";
            } else {
                $table .= "<td>Yes</td>";
                $table .= "<td>{$t->created_at->format('d/m/Y h:i a')}</td>";
                $table .= "<td>{$t->date->format('d/m/Y')}</td>";
            }
            $table .= "</tr>";

            $i++;
        }

        return $table;
    } else {
        return "<tr><td colspan='6'><center>No Entries Found</center></td></tr>";
    }
});

Route::get('people/{nid}', function($nid){
    $people = People::where('nid', $nid)->first();
    $student = Student::where('id_card', $nid)->first();
    $people->student = $student;
    return $people;
});

Route::get('people-name/{name}', function($name){
    return Searchy::people('name')->query($name)->get();
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
    $result = curl_exec($ch); // Getting jSON result string

    $someArray = json_decode($result, true);
    return $someArray;
});

Route::get('/check-for-new-test', function(){
    $url = TheoryUrl::where('new', '1')->first();

    if ($url) {
        return $url;
    } else {
        return 'false';
    }
});

Route::post('/create-new-test', function(Request $request){
    $url = new TheoryUrl;
    $url->url = $request->url;
    $url->save();

    return $url;
});

Route::get('/v2/address/find', function(Request $request) {
    return App\Address::search($request->get('q'))->get();
});