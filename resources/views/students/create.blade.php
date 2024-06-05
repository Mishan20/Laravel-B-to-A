@extends('layouts.main')

@section('title', 'Create Student')
@section('content')
<h1>Student Create</h1>
<a href="{{url('/student')}}" class="btn btn-primary">Back to Student List</a>
<form method="POST" action="{{ url('/student/create')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class=" mb-3">
        <label for=name" class="form-label">Name</label>
        <input value="{{old('name')}}" type="text" class="@error('name') is-invalid @enderror form-control" id="name" name="name" aria-describedby="">
        @error('name')
            <div class="color-red text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email1" class="form-label">Email</label>
        <input value="{{old('email')}}" type="email" class="@error('email') is-invalid @enderror form-control" id="email1" name="email" aria-describedby="">
        @error('email')
            <div class="color-red text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>   
        <input value="{{old('phone')}}" type="text" class="@error('phone') is-invalid @enderror form-control" id="phone" name="phone">
        @error('phone')
            <div class="color-red text-sm">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">
            <input type="checkbox" name="subjects[]" value="subject1" >
            Subject 1
        </label>

        <label for="">
            <input type="checkbox" name="subjects[]" value="subject2">
            Subject 2
        </label>

        <label for="">
            <input type="checkbox" name="subjects[]" value="subject3">
            Subject 3
        </label>

        <label for="">
            <input type="checkbox" name="subjects[]" value="subject4">
            Subject 4
        </label>
        @error('subject[]')
            <div class="color-red text-sm">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <select name="status" class="form-select" aria-label="">
            <option selected value="">Selelct Student Status</option>
            <option value="0">InActive</option>
            <option value="1">Active</option>
            <option value="2">Suspended</option>
        </select>
        @error('status')
            <div class="color-red text-sm">{{ $message }}</div>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection