<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Goal;
use App\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //View your goal tasks
    public function showAll($gid)
    {
        try {
            $goal = Goal::find($gid);
            $user = Auth::user();
            $tasks = Task::where('gid', $gid)->get();
            if($user->uid === $goal->uid){
        return response()->json(['data' =>['success' => true,'tasks' => $tasks]], 201);
            } else {
                return response()->json(['data' =>['message' => 'You are unauthorized to view the tasks']], 404);
            }
        } catch (\Exception $e){
            return response()->json(['data' =>['message' => 'Error']], 409);
        }
    }

    //Create and store a task for a specific goal
    public function store(Request $request, $gid)
    {

    $this->validate($request, [
        'taskname' => 'required|min:4|max:30'
    ]);

    try {
            $goal = Goal::where('gid', $gid)->where('uid', Auth::id())->first();
            $task = new Task();
            $task->gid = $goal->gid;
            $task->taskname = $request->input('taskname');
            $task->save();
    return response()->json(['success' => true, 'data' => ['task' => $task]], 201);
    } catch (\Exception $e) {

        return response()->json(['error' => true, 'message' => 'request failed'], 409);
    }
}
    //Owner is able to edit his task
    public function edit($gid, $tid)
    {
        $task = Task::find($tid);
        $goal = Goal::where('gid', $gid)->first();
        if (Auth::user()->uid !== $goal->uid || $task->gid !== $goal->gid) {
            return response()->json(['success' => false], 404);
        } else {
        return response()->json(['data' => ['success' => true,'goal' => $task]], 201);
        }
    }

    public function update(Request $request, $gid, $tid)
    {
        $this->validate($request, [
            'taskname' => 'required|min:5'
        ]);

        $goal = Goal::where('gid', $gid)->first();
        $task = Task::where('tid', $tid)->first();
        try {
        if (Auth::user()->uid !== $goal->uid || $task->gid !== $goal->gid) {
            return response()->json(['success' => false], 404);
        } else {
            $task->taskname = $request->input('taskname');
            $task->save();
            return response()->json(['data' => ['success' => true, 'message' => 'successfully updated','task' => $task]], 201);
        }
    } catch(\Exception $e) {
        return response()->json(['error' => true, 'message' => 'request failed'], 409);
    }
    }

    public function completetask(Request $request, $gid, $tid)
    {
        $user = Auth::user();
        $goal = Goal::where('gid', $gid)->first();
        $task = Task::where('tid', $tid)->first();
        try {
            if (Auth::user()->uid !== $goal->uid || $task->gid !== $goal->gid) {
                return response()->json(['success' => false], 404);
            } else {
                $task->completed = $request->input('completed');
                $task->save();
        return response('Task Updated Successfully', 200);
            }
         } catch (\Exception $e){
                return response()->json(['error' => true, 'message' => 'request failed'], 409);
            }
    }

    public function uncompletetask(Request $request, $gid, $tid)
    {
        $user = Auth::user();
        $goal = Goal::where('gid', $gid)->first();
        $task = Task::where('tid', $tid)->first();
        try {
            if (Auth::user()->uid !== $goal->uid || $task->gid !== $goal->gid) {
                return response()->json(['success' => false], 404);
            } else {
                $task->completed = $request->input(0);
                $task->save();
        return response('Task Unchecked Successfully', 200);
            }
         } catch (\Exception $e){
                return response()->json(['error' => true, 'message' => 'request failed'], 409);
            }
    }


    public function destroy(Request $request, $gid, $tid)
        {
        $user = Auth::user();
        $goal = Goal::where('gid', $gid)->first();
        $task = Task::where('tid', $tid)->first();
        try {
            if (Auth::user()->uid !== $goal->uid || $task->gid !== $goal->gid) {
                return response()->json(['success' => false], 404);
            } else {
        $task->delete();
        return response('Deleted Successfully', 200);
            }
         } catch (\Exception $e){
                return response()->json(['error' => true, 'message' => 'request failed'], 409);
            }
        }
}
