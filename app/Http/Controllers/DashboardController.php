<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    //
    public function dashboard()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.home.index', ['user' => $user],  ['courses' => $courses]);
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.home.profile', ['user' => $user]);
    }

    public function leaderboard()
    {
        Paginator::useBootstrap();
        $user = auth()->user();
        $allusers = User::orderBy('points', 'desc')->get();
        return view('dashboard.home.leaderboard', ['user' => $user], ['allusers' => $allusers]);
    }

    public function course()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.home.course', ['user' => $user], ['courses' => $courses]);
    }

    public function test()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.home.test.index', ['user' => $user],['courses' => $courses]);
    }

    public function takeTest($id)
    {
        $user = User::findOrFail(auth()->user()->id);
        $course = Course::findOrFail($id);
        $exempted_questions = [];
        $answers = $user->answers()->get();
        // dd($answered);
        foreach ($answers as $answer) {
            // dd($answer->option);
            array_push($exempted_questions, $answer->option->question->id);
        }

        $questions = Question::where('course_id',$course->id)->whereNotIn('id',$exempted_questions)->with('options')->get();

        if(count($questions) < 1){
            $points = 0;
            $coins = 0;
           foreach ($course->questions as $key => $question) {
                if($question->answer->status){
                    $points += 5;
                    $coins += 0.5;
                }
           }
           $user->increment('points', $points);
           $user->increment('coins', $coins);
            return redirect()->to('home/congrats/'.$course->id);
        }
        $question = $questions->first();


        return view('dashboard.home.test.test', ['user' => $user, 'question' => $question, 'count' => $questions->count()]);
    }

    public function finishTest($id)
    {
        $user = auth()->user();
        $course = Course::findOrFail($id);
        $course->load(['questions' => function($query){
            return $query->with('options');
        }]);
        $question = Question::findOrFail($id);
        return view('dashboard.home.test.welcome', ['user' => $user], ['course' => $course], ['question' => $question]);
    }

    public function results($id)
    {

        $user = User::find(auth()->user()->id);

        $course = Course::findOrFail($id);
        $course->load(['questions' => function($query) use ($user){
            return $query->with('options');
        }]);

        return view('dashboard.home.test.result',['course' => $course]);
    }

    public function submitTest(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'option_id' => 'required',
            'question_id' => 'required',
        ]);

        $option = Option::where('question_id', $request->input('question_id'))->where('id', $request->input('option_id'))->firstOrFail();
        // dd($option);

        DB::beginTransaction();

        $answer = Answer::create([
            'user_id' => auth()->user()->id,
            'question_id' => $request->input('question_id'),
            'option_id' => $request->input('option_id'),
            'status' => $option->status,
            'answer' => ''
        ]);

        DB::commit();
        return back();
    }

    public function courses()
    {
        $user = auth()->user();
        $courses = Course::all();
        return view('dashboard.allcourse', ['user' => $user], ['courses' => $courses]);
    }

    public function questions($id)
    {
        $user = auth()->user();
        $courses = Course::findOrFail($id);
        $courses->load([
            'questons' => function ($query) {
                dd($query);
            }
        ]);
        $allquestions = Option::with('question');
        return view('dashboard.allquestion', ['user' => $user], ['courses' => $courses], ['allquestions' => $allquestions]);
    }

    // public function question()
    // {
    //     Paginator::useBootstrap();
    //     $questions = Question::with('options')->paginate(1);
    //     $user = auth()->user();
    //     return view('dashboard.question', ['user' => $user], ['questions' => $questions]);
    // }

    public function createQuestion ()
    {
        $user = auth()->user();
        return view('dashboard.createquestion', ['user' => $user]);
    }

    public function editProfile()
    {
        $user = User::findOrFail(auth()->user()->id);
        return view('dashboard.home.editprofile', ['user' => $user]);
    }

    public function saveProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $valid = $request->validate([
            'name' => ['required'],
            'surname' => ['required'],
            'username' => ['required', Rule::unique('users')->ignore($user)],
            'email' => ['required', Rule::unique('users')->ignore($user)],
            'password' => 'required|confirmed|min:8',
            'nationality' => ['required'],
            'gender' => ['required'],
            'dob' => ['required'],
            'image' => ['nullable', 'mimes:jpg,png,jpeg']
        ]);

        if ($request->hasFile('image')) {
            $user->update(array_merge($valid, ['image' => $request->file('image')->store('user_images', 'public')]));
        }
        else {
            $user->update(array_merge($valid));
        }
        return redirect()->intended('home')->with('home.profile')->withInput($request->input())->with('message', 'Profile Updated');
    }

    public function users() {
        $user = auth()->user();
        $users = User::all();
        return view('admin.users.index', ['user' => $user], ['users' => $users]);
    }

    public function logOut(Request $request) {
        $request->session()->flush();
        return redirect()->route('login');
    }

    // public function logOut(Request $request) {
    // {
    //     $user = auth()->user();
    //     $logout = $request->session()->flush();
    // }

}
