<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.home');
            case 3:
            case 4:
                return view('lecturer.home');
            case 5:
                return view('departmentadmin.home');
            case 6:
                return view('systemadmin.home');
        }
    }

    public function searchMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return view('student.searchmarks')->with('courses', array());
            case 3:
            case 4:
                return view('lecturer.searchmarks');
            case 5:
                return view('departmentadmin.searchmarks');
            case 6:
                return view('systemadmin.searchmarks');
        }
    }

    public function getMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return view('student.searchmarks')->with('courses', app('App\Http\Controllers\StudentController')->getMarks($request));
            case 3:
            case 4:
                return view('lecturer.searchmarks');
            case 5:
                return view('departmentadmin.searchmarks');
            case 6:
                return view('systemadmin.searchmarks');
        }
    }

    public function myMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return app('App\Http\Controllers\StudentController')->studentHome();
            default:
                return view('student.access_denied');
        }
    }

    public function myMarksFilter(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return app('App\Http\Controllers\StudentController')->marksfilter($request);
            default:
                return view('student.access_denied');
        }
    }

    public function lecturerCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.lecturing_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getLecturerCourses($request));
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }
    public function conveningCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.convening_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getConveningCourses($request));
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }
    public function otherCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.other_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getOtherCourses($request));
            case 5:
                return view('departmentadmin.courses')->with('courses', app('App\Http\Controllers\LecturerController')->getOtherCourses($request));
            case 6:
                return view('systemadmin.courses')->with('courses', app('App\Http\Controllers\LecturerController')->getOtherCourses($request));
        }
    }

    public function taCourses(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return app('App\Http\Controllers\StudentController')->taFilter(null);
            case 3:
            case 4:
            case 5:
            case 6:
                return redirect()->route('courses');
        }
    }

    public function getTaCourse($courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return app('App\Http\Controllers\StudentController')->getTaCourse($courseId);
            case 3:
            case 4:
            case 5:
            case 6:
                return redirect()->route('courses');
        }
    }

    public function taCoursesFilter(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return app('App\Http\Controllers\StudentController')->taFilter($request);
            case 3:
            case 4:
            case 5:
            case 6:
                return redirect()->route('courses');
        }
    }


    public function admin(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.access_denied');
            case 5:
                return view('departmentadmin.admin');
            case 6:
                return view('systemadmin.admin');
        }
    }

}
