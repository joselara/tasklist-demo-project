<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TaskController extends Controller
{
    private $validationRules = [
        'name' => 'required|max:255',
        'priority' => 'required|integer',
        'completed' => 'boolean'
    ];

    public function index(Request $request)
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => $request->user()->tasks()->orderBy('priority', 'asc')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Tasks/Form');
    }

    public function store(Request $request)
    {
        $validData = $this->validate($request)->validateWithBag('createTask');

        $request->user()->tasks()->save(
            Task::make($validData)
        );

        return Inertia::location(route('tasks.index'));;
    }

    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Form', [
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validData = $this->validate($request)->validateWithBag('updateTask');

        $task->update($validData);

        return Inertia::location(route('tasks.index'));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return Inertia::location(route('tasks.index'));
    }

    public function updatePriorities(Request $request)
    {
        $tasks = $request->tasks;

        foreach($tasks as $index => $task) {
            Task::where('id', $task['id'])->update(['priority' => $index + 1]);
        }

        return Inertia::render('Tasks/Index', [
            'tasks' => $request->user()->tasks()->orderBy('priority', 'asc')->get()
        ]);
    }

    private function validate(Request $request)
    {
        return Validator::make($request->all(), $this->validationRules);
    }

}
