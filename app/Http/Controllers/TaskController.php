<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    public function index()
    {
        $task = Task::where('status',0)->get();
        return view('Tasks/index',compact('task'));
      
    }
    public function getTasks(){
        $task = Task::all();
          return response()->json($task);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required|string|unique:tasks,task',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task = Task::create([
            'task' => $request->task,
            'status' => 1,
        ]);

        return response()->json($task);
    }

    // Update a task's completion status
    public function update(Request $request, Task $task)
    {
        $task->update([
            'status' => $request->completed,
        ]);
        return response()->json($task);
    }

    // Delete a task
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
