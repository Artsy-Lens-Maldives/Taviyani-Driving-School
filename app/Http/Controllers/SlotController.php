<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Category;
use App\Time;
use App\Slot;
use App\Student;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::all();
        return $slots;
    }
    
    public function reset_slots()
    {
        $slots = Slot::all();

        foreach ($slots as $slot) {
            $slot->delete();
        }
        
        $instructors = Instructor::all();
        $times = Time::all();
        
        foreach ($instructors as $instructor) {
            foreach ($times as $time) {
                $slot = new Slot;
                $slot->instructor_id = $instructor->id;
                $slot->time_id = $time->id;
                $slot->save();
            }
        }

        return redirect('/slot');
    }

    public function get_instructors_slots($instructor_id)
    {
        $instructor = Instructor::find($instructor_id);
        return $instructor->slots;
    }

    public function switch_students_slot($id, $new_id, $student_id)
    {
        $slot = Slot::find($id);
        $slot->student_id = 0;
        $slot->isEmpty = 1;
        $slot->save();
    
        $new_slot = Slot::find($new_id);
        $new_slot->student_id = $student_id;
        $new_slot->isEmpty = 0;
        $new_slot->save();
    
        return redirect('/table');
    }
}
