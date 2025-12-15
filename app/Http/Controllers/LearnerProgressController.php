<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learner;
use App\Models\Enrolment;
use App\Models\Course;

class LearnerProgressController extends Controller
{


    //
//     public function index(string $course = '', string $progress= 'yes')
//     {
//         // $courses = Course::all();
//         // $enrolments = Enrolment::all(); 
        
        
//         $learners = Learner::with(['courses'=> function($query) use ($course){
//             $query->when($course != null, function ($query) use ($course) {
//             $query->where('name', $course);
//         });
//         }])->get();



//         foreach ($learners as $learner) {
//             # code...
//             if (empty($learner->courses) || $learner->courses->count() == 0) {
//                 # code...
//                 $learners = $learners->reject(function ($listlearner) use ($learner) {
//                   return $learner->id === $listlearner->id;
//                 });
//             }
//         }

//         if ($progress != null && $progress != '') {
//             //  usort($learners, function ($a, $b) {
//             //     return $a->progress <=> $b->progress;
//             //  } );
//             $flattened = $learners->map(function ($learner) {
//                 if ($learner->courses != null) {
//                     $learner1 = $learner->toArray();
//                     $course1 = $learner->coureses->toArray();

//                     return array_merge($learner1, $course1);
//                     # code...
//                 }
//             });
            
//             $flattened->sortBy('courses.progress');
//             $learners = $flattened;
            
//         }



//         syslog(LOG_DEBUG,$learners);
        
        
// // $query->where('name', '=',$course );
//                 // syslog(LOG_DEBUG,$query->dump());

        

//         $courses = Course::orderBy('name','asc')->get();

//         return view('learner-progress_index', compact('learners', 'courses', 'course'));

//     }

public function index(string $courseFilter = '', string $progress= '')
    {
        // $courses = Course::all();
        // $enrolments = Enrolment::all(); 
        
        
        $learners = Learner::all();

        $enrolments = Enrolment::all();

        $courses = Course::orderBy('name','asc')->get();

        return view('learner-progress_index', compact('learners', 'courses', 'enrolments', 'courseFilter', 'progress'));

    }


}
