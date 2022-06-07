@extends('layouts.base')

@section('title', 'Добавление задания :: Мои задания')

@section('main')
    <form action="{{ route('task.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="txtTitel">Задание</label>
            <input name="title" id="txtTitle" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title') }}">
            @error('title')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="txtDescription">Описание</label>
            <textarea name="description" id="txtDescription" row="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label for="userfile">Прикрепить файл</label>
            <input type="file" name="userfile">
        </div>
        <br>
        <div class="form-group">
            <label for="startDate">Дата старта</label>
            <input type="datetime-local" name="startDate" class="form-control @error('startDate') is-invalid @enderror"
                value="{{ old('startDate') }}">
            @error('startDate')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label for="endDate">Дата завершения</label>
            <input type="datetime-local" name="endDate" class="form-control @error('endDate') is-invalid @enderror"
                value="{{ old('endDate') }}">
            @error('endDate')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @if (isset($_GET['message']))
            <p class="text-right" style="color: red;">{{ $_GET['message'] }}</p>
        @endif
        <br>
        <input type="submit" value="Добавить" class="btn btn-primary">
    </form>

@endsection
