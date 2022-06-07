<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use Illuminate\Support\Carbon;

class HomeController extends Controller
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

    private const TASK_VALIDATOR = [
        'title' => 'required|max:50',
        'description' => 'required|max:255',
        'startDate' => 'required',
        'endDate' => 'required'
    ];

    private const TASK_ERROR_MESSAGE = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длиннее :max символов',
        'startDate.required' => 'Укажите дату старта',
        'endDate.required' => 'Укажите дату завершения',

    ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->hasRole('manager')) {
            $allTasks = Task::all();
            return view('manager', ['tasks' => $allTasks]);
        } else {
            return view('home', ['tasks' => Auth::user()->tasks()->latest()->get()]);
        }
    }

    public function showAddTaskForm()
    {
        $lastUserTask = Auth::user()->tasks()->latest()->first();
        $experateDate = Carbon::create($lastUserTask->created_at)->addDay();
        $currentDate = Carbon::now();
        if (Auth::user()->hasRole('client') && $currentDate->gte($experateDate)) {
            return view('task_add');
        } else {
            return redirect()->route('home', ['message' => 'Вы сегодня уже создавали задние']);
        }
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate(self::TASK_VALIDATOR, self::TASK_ERROR_MESSAGE);
        if ($request->isMethod('post') && $request->file('userfile')) {
            $file = $request->file('userfile');
            $uploadFolder = 'public/uploads';
            $name = $file->hashName();
            $extension = $file->extension();
            $path = Storage::putFileAs($uploadFolder, $file, $name);
        } else {
            $path = null;
        }

        $taskInDiapazone = Task::where('start_data', '>=', $validated['startDate'])->where('end_data', '<=', $validated['endDate'])->count();

        if ($taskInDiapazone < 4) {
            Auth::user()->tasks()->create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'path_to_file' => $path,
                'start_data' => $validated['startDate'],
                'end_data' => $validated['endDate']
            ]);
            return redirect()->route('home');
        } else {
            return redirect()->route('task.add', ['message' => 'Выберите другой интервал времени']);
        }
    }

    public function showEditTaskForm(Task $task)
    {
        return view('task_edit', ['task' => $task]);
    }

    public function updateTask(Request $request, Task $task)
    {
        $task->fill(['finish_task' => $request->status]);
        $task->save();
        return redirect()->route('home');
    }
}
