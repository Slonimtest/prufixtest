@extends('layouts.base')

@section('title', 'Мои задания')

@section('main')
    <h2>Добро пожаловать, {{ Auth::user()->name }}!</h2>
    @if (count($tasks) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Задание</th>
                    <th>Описание</th>
                    <th>Имя клиента</th>
                    <th>Почта клиента</th>
                    <th>Прикрепленный файл</th>
                    <th>Дата создания</th>
                    <th>Дата старта</th>
                    <th>Дата завершения</th>
                    <th>Статус задания</th>
                    <th>Изменить</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>
                            <h3>{{ $task->title }}</h3>
                        </td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->user->name }}</td>
                        <td>{{ $task->user->email }}</td>
                        <td>{{ $task->path_to_file }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>{{ $task->start_data }}</td>
                        <td>{{ $task->end_data }}</td>
                        @if ($task->finish_task)
                            <td style="color: green;">Выполнено</td>
                        @else
                            <td style="color: red;">Не выполнено</td>
                        @endif
                        <td><a href="{{ route('task.edit', ['task' => $task->id]) }}">Изменить</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

@endsection
