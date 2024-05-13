@extends('layouts.main')

@section('title', 'Create Student')
@section('content')
<h1>Student Create</h1>
<a href="{{url('/student')}}" class="btn btn-primary">Back to Student List</a>
<form method="POST" action="{{ url('/student/create')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class=" mb-3">
        <label for=name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="">
    </div>
    <div class="mb-3">
        <label for="email1" class="form-label">Email</label>
        <input type="email" class="form-control" id="email1" name="email" aria-describedby="">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection