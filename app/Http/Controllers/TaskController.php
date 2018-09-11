<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Task;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::where('user_id', JWTAuth::user()->id)->get();

        return $tasks;
    }

    public function store(Request $request) {
        $this->validate($request, [
            'task' => 'required|min:4'
        ]);
           
        $task = new Task();
        
        $task->task = $request->input('task');
        $task->is_priority = false;
        $task->is_done = false;
        $task->user_id = \JWTAuth::user()->id;

        $task->save();        

        return $task;
    }

    public function update(Request $request, $id) {
        $task = Task::find($id);

        if(array_has($request->all(), 'task')) {
            $this->validate($request, [
                'task' => 'required|min:4'
            ]);           
            
            $task->task = $request->input('task');
        }

        if(array_has($request->all(), 'is_priority'))
            $task->is_priority = $request->input('is_priority');

        if(array_has($request->all(), 'is_done'))
            $task->is_done = $request->input('is_done');

        $task->save();        

        return $task;
    }

    public function delete($id) {
        $task = Task::find($id);

        $task->delete();

        return response()->json(['response' => true]);
    }
}
