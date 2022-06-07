@extends('layouts.base')

@section('title', 'Правка задания')

@section('main')
    <form action="{{ route('task.update', ['task' => $task->id]) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="status">Статус</label>
            <select name="status" id="status">
                <option value="0">Не выполнено</option>
                <option value="1">Выполнено</option>
            </select>
        </div>
        <input type="submit" value="Сохранить" class="btn btn-primary">
    </form>

@endsection
