<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTask;
use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->hasRole('admin')? Task::all():auth()->user()->tasks;
        $users = User::all();

        return Inertia::render("Tasks/Index", ['tasks' => $tasks, 'users' => $users]);
    }

    public function store(CreateTask $request)
    {
        Task::create($request->validated());

    }

    public function update(Task $task, CreateTask $request)
    {
        $task->update($request->validated());

    }

    public function destroy(Task $task)
    {
        $task->delete();
    }
}
