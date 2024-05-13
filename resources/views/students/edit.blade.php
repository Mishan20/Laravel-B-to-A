@extends('layouts.main')

@section('title', 'Edit Student Details')
@section('content')
<h1>Edit Student Details</h1>
<a href="{{url('/student')}}" class="btn btn-primary">Back to Student List</a>
<form method="POST" action="{{ url('/student/edit/'. $student->id)}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class=" mb-3">
        <label for=name" class="form-label">Name</label>
        <input value="{{$student->name}}" type="text" class="form-control" id="name" name="name" aria-describedby="">
    </div>
    <div class="mb-3">
        <label for="email1" class="form-label">Email</label>
        <input value="{{$student->email}}" type="email" class="form-control" id="email1" name="email" aria-describedby="">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input value="{{$student->phone}}" type="text" class="form-control" id="phone" name="phone">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection