<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create_pivot_from_comma_table()
    {
        $instructors = Instructor::all();
        \DB::table('category_instructor')->truncate();
        
        foreach ($instructors as $instructor) {
            foreach(explode(',', $instructor->category) as $id) {
                \DB::table('category_instructor')->insert(
                    ['category_id' => $id, 'instructor_id' => $instructor->id]
                );
            }
        }

        return redirect('instructor');
    }
}
