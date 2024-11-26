<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    public function index()
    {
        return view('admin.course.index',[
            'courses' => Course::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = auth()->user();
        return view('admin.course.addcourse', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'course' => 'required',
            'level' => 'required',
        ]);

        DB::beginTransaction();

        $answer = Course::create([
            'name' => $request->input('course'),
            'level' => $request->input('level')
        ]);

        DB::commit();
        return redirect()->intended('admin/courses')->with('message', 'Course Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    // Courses

    public function week1()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week1', ['user' => $user]);
    }

    public function week2()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week2', ['user' => $user]);
    }

    public function week3()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week3', ['user' => $user]);
    }

    public function week4()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week4', ['user' => $user]);
    }

    public function week5()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week5', ['user' => $user]);
    }

    public function week6()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week6', ['user' => $user]);
    }

    public function week7()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week7', ['user' => $user]);
    }

    public function week8()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week8', ['user' => $user]);
    }

    public function week9()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week9', ['user' => $user]);
    }

    public function week10()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week10', ['user' => $user]);
    }

    public function week11()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week11', ['user' => $user]);
    }

    public function week12()
    {
        $user = auth()->user();
        return view('dashboard.home.courses.week12', ['user' => $user]);
    }
}
