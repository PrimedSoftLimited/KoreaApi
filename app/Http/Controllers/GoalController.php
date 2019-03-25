<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Goal;
use App\Task;
use Mockery\CountValidator\Exception;

class GoalController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $goals = Goal::where('uid', $user->uid)->get();
        return response()->json(['data' => ['success' => true, 'goals' => $goals]], 201);
    }

    public function store(Request $request)
    {

    $this->validate($request, [
        'goalname' => 'required|min:4|max:30',
        'goalbody' => 'required|min:5'
    ]);

    $goal = new Goal;
    $goal->goalname = $request->input('goalname');
    $goal->goalbody = $request->input('goalbody');
    $goal->uid = Auth::user()->uid;
    $checkgoal = $goal->save();
    //Auth::user()->goal()->Create($request->all())
        if($checkgoal)
        {

        //return response()->json(['status' => 'success']);
        return response()->json(['data' => ['success' => true, 'message' => 'inserted successfully', 'goal' => $goal]], 201);
    }
}

    public function show($gid)
    {
        $user = Auth::user();
        // if ($user)
        // {
        // $goal = Goal::where('uid', $user->uid)->where('gid', $gid)->get();
        // $goal = Goal::findOrFail($gid);
        $goal = Goal::find($gid);
        if (Auth::user()->uid !== $goal->uid) {
            return response()->json(['Message' => "Unauthorized"], 403);
        } else {
        return response()->json(['data' => ['success' => true, 'goal' => $goal]], 201);
        }
    }

    public function edit($gid)
    {
        $goal = Goal::find($gid);
        try {
        if (Auth::user()->uid !== $goal->uid) {
            return response()->json(['success' => false], 403);
        } else {
        return response()->json(['data' => ['success' => true,'goal' => $goal]], 201);
        }
    } catch (\Exception $e){
        return response()->json(['success' => false], 403);
    }

    }

    public function update(Request $request, $gid)
    {
        $this->validate($request, [
            'goalname' => 'required|min:4|max:30',
            'goalbody' => 'required|min:5'
        ]);

        $goal = Goal::find($gid);
        try {
        if (Auth::user()->uid !== $goal->uid) {
            return response()->json(['success' => false], 403);
        } else {
            $goal->goalname = $request->input('goalname');
            $goal->goalbody = $request->input('goalbody');
            $goal->save();
            return response()->json(['data' => ['success' => true, 'message' => 'successfully updated','goal' => $goal]], 201);
        }
    } catch(\Exception $e) {
        return response()->json(['error' => true, 'message' => 'request failed'], 409);
    }

    }

    public function destroy($gid)
    {
        try {
        $goal = Goal::find($gid);
        //$task = Task::where('gid', $goal->gid)->get();
        if(Auth::user()->uid === $goal->uid){
            DB::table('tasks')->where('gid', '=', $goal->gid)->delete();
            Goal::destroy($gid);
             return response()->json(['data' => ['success' => 'deleted successfully']], 201);
        }
    } catch (\Exception $e) {
        return response()->json(['data' => ['message' => 'unable to delete']], 403);
    }
    }

}
