@extends('layouts.base')

@section('title', 'Мои задания')

@section('main')
    <h2>Добро пожаловать, {{ Auth::user()->name }}!</h2>
    <p class="text-right"><a href="{{ route('task.add') }}">Добавить задание</a></p>
    @if (isset($_GET['message']))
        <p class="text-right" style="color: red;">{{ $_GET['message'] }}</p>
    @endif
    @if (count($tasks) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Задание</th>
                    <th>Описание</th>
                    <th>Прикрепленный файл</th>
                    <th>Дата старта</th>
                    <th>Дата завершения</th>
                    <th>Статус задания</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>
                            <h3>{{ $task->title }}</h3>
                        </td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->path_to_file }}</td>
                        <td>{{ $task->start_data }}</td>
                        <td>{{ $task->end_data }}</td>
                        @if ($task->finish_task)
                            <td style="color: green;">Выполнено</td>
                        @else
                            <td style="color: red;">Не выполнено</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

@endsection
