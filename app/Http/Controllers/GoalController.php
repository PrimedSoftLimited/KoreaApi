<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Goal;

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
        // $goals = Auth::user()->goal()->get();
        $goals = Goal::orderBy('created_at', 'desc')->get();
        return response()->json(['status' => 'success','goal' => $goals]);
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
        return response()->json(['data' => ['goal' => $goal]], 201);
    }
}

    public function show($gid)
    {
    $goal = Goal::where('gid',$gid)->get();
    //return response()->json($goal);
    return response()->json(['data' => ['goal' => $goal]], 201);
    }

    public function edit($gid)
    {
        $goal = Goal::find($gid);
        if (Auth::user()->uid !== $goal->uid) {
            return response()->json(['success' => false], 403);
        } else {
        return response()->json(['success' => true,'data' => ['goal' => $goal]], 201);
        }

    }

    public function update(Request $request, $gid)
    {
        $this->validate($request, [
            'goalname' => 'required|min:4|max:30',
            'goalbody' => 'required|min:5'
        ]);

        $goal = Goal::find($gid);
        if (Auth::user()->uid !== $goal->uid) {
            return response()->json(['success' => false], 403);
        } else {
            $goal->goalname = $request->input('goalname');
            $goal->goalbody = $request->input('goalbody');
            $goal->save();
            return response()->json(['success' => true,'data' => ['goal' => $goal]], 201);
        }

    }

    public function destroy($gid)
    {
        $goal = Goal::find($gid);
        if(Auth::user()->uid === $goal->uid && Goal::destroy($gid)){
             return response()->json(['success' => 'deleted successfully'], 201);
        }
        return response()->json(['success' => 'failed'], 403);
    }

}
