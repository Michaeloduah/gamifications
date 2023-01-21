<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function leaderboard()
    {
        try {
            $user = auth()->user();
            $allusers = User::orderBy('points', 'desc')->get();

            return response()->json([
                'status' => true,
                'message' => 'All user is now Available',
                'logged_in_user' => $user,
                'All_users' => $allusers
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error',
                'errors' => $th->getMessage()
            ]);
        }
    }

    public function course()
    {
        try {
            $course = Course::all();

            return response()->json([
                'status' => true,
                'message' => 'All courses is now available',
                'All Courses' => $course
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error',
                'errors' => $th->getMessage()
            ]);
        }
    }

    public function question($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->load(['questions' => function($query){
                return $query->with('options');
            }]);

            return response()->json([
                'status' => true,
                'message' => 'This contain the course, questions and options for the questions',
                'Courses, Questions and Options' => $course
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error',
                'errors' => $th->getMessage()
            ]);
        }
    }

    // public function question()
    // {
    //     try {


    //         return response()->json([
    //             'status' => true,
    //             'message' => 'List of Courses',
    //             'Logged in user' =>' '
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Server Error',
    //             'errors' => $th->getMessage()
    //         ]);
    //     }
    // }
}
