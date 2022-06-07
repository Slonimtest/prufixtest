<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = ['tasks' => Task::latest()->get()];
        return view('index', $tasks);
    }

    public function detail(Task $task)
    {
        $s = $task->title . "\r\n";
        $s .= $task->description . "\r\n";
        $s .= $task->path_to_file . "\r\n";
        $s .= $task->finish_task . "\r\n";

        return response($s)->header('Content-type', 'text/plain');
    }
}
