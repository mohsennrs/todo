<?php

namespace Hattori\ToDo\Controllers;

use Illuminate\Http\Request;
use Hattori\ToDo\Models\Task;
use Illuminate\Routing\Controller;
use Hattori\ToDo\Resources\TaskResource;
use Hattori\ToDo\Resources\TaskCollection;
use Hattori\ToDo\Requests\CreateTaskRequest;
use Hattori\ToDo\Requests\UpdateTaskRequest;
use Hattori\ToDo\Notifications\TaskStatusChanged;

class TaskController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', auth()->user()->id)->where(function($q) use($request) {
            if($request->get('title')) {
                $q->where('title', 'like', '%'.$request->get('title').'%');                
            }
        })->whereHas('labels', function($q) use ($request) {
            if($request->get('labels')) {
                $q->whereIn('id', $request->get('labels'));                
            }

        })->with(['labels'])->orderBy('created_at', 'desc')->get();

        return new TaskCollection($tasks);
    }

    public function store(CreateTaskRequest $request) {
        $task = auth()->user()->tasks()->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]); 

        $task->labels()->sync($request->get('labels'));

        return response(['message' => 'success', 'data' => new TaskResource($task)], 201);
    }

    public function update(UpdateTaskRequest $request, $id) {
        $task = Task::findOrFail($id);
        $task->fill([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'status' => $request->get('status')
        ]);

        if($task->isDirty('status')) {
            auth()->user()->notify(new TaskStatusChanged($task));
        }
        $task->save();
        if($request->get('labels')) {
             $task->labels()->sync($request->get('labels'));            
        } else {
            $task->labels()->detach();
        }

        $task->load('labels');
        return response(['message' => 'success', 'data' => new TaskResource($task)], 200);
    }


	public function show($id) {
		$task = Task::where('id', $id)->with('labels')->firstOrFail();

        return response(['data' => new TaskResource($task)], 200);
	}
}
