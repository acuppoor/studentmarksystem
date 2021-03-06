<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\DeptAdminDeptMap;
use App\LecturerCourseMap;
use App\TACourseMap;
use App\UserDepartmentMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /*
     * This class mainly acts as a middleware between the routes and the other controllers.
     * All routes redirects to a method in this class, and some checks are done.
     * Checks such as user authentication and determining if user is permitted to do the operation in question.
     * If user is permitted to do the operation, the correct method from the correct controller is called.
     * Therefore this class functions do not require special comments since all follow the same approach.
     * all the functions names used here are similar in the controller being called, example,
     * getAccount(Request) function in this class calls the getAccount(Request) function in the
     * SysAdminController. The getAccount(Request) in SysAdminController has the details about how accounts are retrieved.
     * */


    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * returns the home page depending on the user's role
     * */
    public function home()
    {
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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

    /*
     * return the searchmarks page for the user depending on his role
     * initially there is no result
     * */
    public function searchMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return view('student.searchmarks')->with('courses', array());
            case 3:
            case 4:
                return view('lecturer.searchmarks')->with('courses', array());
            case 5:
                return view('departmentadmin.searchmarks')->with('courses', array());
            case 6:
                return view('systemadmin.searchmarks')->with('courses', array());
        }
    }

    /*
     * return the searchmarks page with the result being a list of courses
     * delegates the request to the appropriate controller based on the user role id
     * */
    public function getMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return view('student.searchmarks')->with('courses', app('App\Http\Controllers\StudentController')->getMarks($request));
            case 3:
            case 4:
                return view('lecturer.searchmarks')->with('courses', app('App\Http\Controllers\LecturerController')->getMarks($request));
            case 5:
                return view('departmentadmin.searchmarks')->with('courses', app('App\Http\Controllers\LecturerController')->getMarks($request));
            case 6:
                return view('systemadmin.searchmarks')->with('courses', app('App\Http\Controllers\SysAdminController')->getMarks($request));
        }
    }

    /*
     * return the 'my_marks' page for student/TA
     * and prevents other kind of users from accessing the page
     * */
    public function myMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return app('App\Http\Controllers\StudentController')->studentHome();
            case 3:
            case 4:
                return view('lecturer.access_denied');
            case 5:
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /*
     * filter the marks availables for student/TA
     * */
    public function myMarksFilter(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return app('App\Http\Controllers\StudentController')->marksfilter($request);
            case 3:
            case 4:
                return view('lecturer.access_denied');
            case 5:
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /*
     * get the courses for which the logged-in user is a lecturer
     * */
    public function lecturerCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /*
     * get the concening courses for the logged-in user
     * */
    public function conveningCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
                return view('lecturer.convening_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getConveningCourses($request));
            case 5:
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /**
     * checks if department admin is an admin for the department of the course
     * or if the user is a system admin, then just return the details without further check
     * or if the user is a convenor for the course, then return the details with full access
     * or if the user is a lecturer/TA, then return the details with limitied access
     * for any other user, access is denied
     * returns the course management page with the course details
     * @param $courseId
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCourseDetails($courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        $course = Course::where('id', $courseId)->first();
        if($roleID == 5){
            if(!$course){
                return view('departmentadmin.access_denied');
            }
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                    ->where('department_id', $course->department->id)->first();
            if($deptMap && $deptMap->status == 1) {
                return app('App\Http\Controllers\DeptAdminController')->getCourseDetails($courseId);
            } else {
                return view('departmentadmin.access_denied');
            }
        } else if($roleID == 6){
            return view('systemadmin.course_details_super')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        }

        $convenorMap = ConvenorCourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();
        $lecturerMap = LecturerCourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();
        $taMap = TACourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();

        if($convenorMap && $convenorMap->status == 1 && ( $roleID == 4)){
            return view('lecturer.course_details_convenor')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($lecturerMap && $lecturerMap->status == 1 && ($roleID == 3 || $roleID == 4)){
            return view('lecturer.course_details_lecturer')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($roleID == 3 || $roleID == 4){
            if(!$course){
                return view('lecturer.access_denied');
            }
            $deptMap = UserDepartmentMap::where('user_id', Auth::user()->id)
                ->where('department_id', $course->department->id)->first();
            if($deptMap) {
                return view('lecturer.course_details_other')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
            } else {
                return view('lecturer.access_denied');
            }
        } else if($taMap && $taMap->status == 1 && $roleID == 2) {
            return view('student.course_details_ta')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        }
        return view('student.access_denied');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCourse(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return app('App\Http\Controllers\DeptAdminController')->createCourse($request);
            case 6:
                return app('App\Http\Controllers\SysAdminController')->createCourse($request);
        }
    }

    /**
     * Delete a course, only available to dept admins and sys admins
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteCourse(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return app('App\Http\Controllers\DeptAdminController')->deleteCourse($request);
            case 6:
                return app('App\Http\Controllers\SysAdminController')->deleteCourse($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateCourseInfo(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 5:
            case 6:
                return app('App\Http\Controllers\LecturerController')->updateCourseInfo($request);
        }
    }

    /**
     * Add a convenor to a course
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCourseConvenor(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addCourseConvenor($request);
        }
    }

    /**
     * add a lecturer to a course
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addLecturer(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addLecturer($request);
        }
    }

    /**
     * Add TA to a course
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addTA(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addTA($request);
        }
    }

    /**
     * returns the path for the course studentslist so that it can be downloaded on the client's side
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function participantsList(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                throwException();return;
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->participantsList($request);
        }
    }

    /**
     * allows CC, dept admin and sys admin to create coursework
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException(); return;
            case 4:
            case 5:
            case 6:
                return app('App\Http\Controllers\LecturerController')->createCoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException(); return;
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->deleteCoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException(); return;
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->createSubcoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException();
                return;
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->deleteSubcoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getConvenors(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                throwException();
                return;
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getConvenors($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLecturers(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                throwException(); return;
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getLecturers($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudents(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('lecturer.access_denied');
            case 3:
            case 2:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getStudents($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTAs(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getTAs($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSubminimumRow(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 4:
            case 6:
                return app('App\Http\Controllers\LecturerController')->createSubminimumRow($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSection(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSection($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteSection(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSection($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSubminimum(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSubminimum($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteSubminimumRow(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimumRow($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteSubminimum(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimum($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSubCourseworks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 4:
            case 6:
            return app('App\Http\Controllers\LecturerController')->getSubCourseworks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudentsCourseworkMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsCourseworkMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudentsSubcourseworkMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsSubcourseworkMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateSectionMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSectionMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approveUsers(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->approveUsers($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function convenorsAccess(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->convenorsAccess($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lecturersAccess(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->lecturersAccess($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tasAccess(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->tasAccess($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateCoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateSubcoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateSection(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSection($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateSubminimum(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateSubminimum($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateSubminimumRow(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSubminimumRow($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateStudentsList(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateStudentsList($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadSectionMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 4:
            case 6:
                return app('App\Http\Controllers\LecturerController')->uploadSectionMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getGradeTypes(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getGradeTypes($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSections(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getSections($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudentsMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsMarks($request);
        }
    }

    /**
     * get courses which the user is not lecturing or convening
     * @param Request|null $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function otherCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return app('App\Http\Controllers\DeptAdminController')->getCourses($request);
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getCourses($request);
        }
    }

    /**
     * @param Request|null $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateFinalGrade(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID) {
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateFinalGrade($request);
        }

    }

    /**
     * @param Request|null $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downloadFinalGrade(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID) {
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->downloadFinalGrade($request);
        }

    }

    /**
     * @param Request|null $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downloadDPList(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID) {
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->downloadDPList($request);
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function taCourses(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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

    /**
     * @param $courseId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getTaCourse($courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function taCoursesFilter(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.admin')->with('faqs',  app('App\Http\Controllers\SysAdminController')->getFAQs());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faculties(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getFaculties();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDepartments(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getDepartments($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addDepartmentAdmin(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->addDepartmentAdmin($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addFaculty(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->addFaculty($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addDepartment(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->addDepartment($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateFaculty(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->updateFaculty($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteFaculty(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->deleteFaculty($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateDepartment(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->updateDepartment($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteDepartment(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->deleteDepartment($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPassword(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->resetPassword($request);
        }
    }

    /**
     * Takes in an email address which needs to be approved
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approveByEmail(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->approveByEmail($request);
        }
    }

    /**
     * Checks if user is approved and that he is logged in. then returns the profile page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profilePage(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.profile');
            case 3:
            case 4:
                return view('lecturer.profile');
            case 5:
                return view('departmentadmin.profile');
            case 6:
                return view('systemadmin.profile');
        }
    }

    /**
     * this method make sure that only a system admin can do this operation
     * @param Request $request
     * @return $this
     */
    public function changePassword(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        app('App\Http\Controllers\GeneralController')->changePassword($request);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function updatePersonalInfo(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        app('App\Http\Controllers\GeneralController')->updatePersonalInfo($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getFaculties(Request $request){
        $this->checkApproval();
        return app('App\Http\Controllers\GeneralController')->getFaculties($request);
    }

    /**
     * makes sure that only system admin can create FAQ
     * @param Request $request
     * @return $this
     */
    public function addFAQ(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        if(Auth::user()->role_id != 6){
            throwException();
        }
        return app('App\Http\Controllers\SysAdminController')->addFAQ($request);
    }

    /**
     * makes sure that only system admin can reject an account
     * @param Request $request
     * @return $this
     */
    public function rejectAccount(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        if(Auth::user()->role_id != 6){
            throwException();
        }
        return app('App\Http\Controllers\SysAdminController')->rejectAccount($request);
    }

    /**
     * makes sure that only system admin can update FAQ
     * @param Request $request
     * @return $this
     */
    public function updateFAQ(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        if(Auth::user()->role_id != 6){
            throwException();
        }
        return app('App\Http\Controllers\SysAdminController')->updateFAQ($request);
    }

    /**
     * make sure that only sysadmin can delete FAQ
     * @param Request $request
     * @return $this
     */
    public function deleteFAQ(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        if(Auth::user()->role_id != 6){
            throwException();
        }
        return app('App\Http\Controllers\SysAdminController')->deleteFAQ($request);
    }

    /**
     * makes sure that only system admin can request any account's info
     * @param Request $request
     * @return $this
     */
    public function getAccount(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login')->with('accountNotApproved', "Your account has not been approved yet. Please send an email on xpy@marksystem.co.za");
        }
        if(Auth::user()->role_id != 6){
            throwException();
        }
        return app('App\Http\Controllers\SysAdminController')->getAccount($request);
    }

}
