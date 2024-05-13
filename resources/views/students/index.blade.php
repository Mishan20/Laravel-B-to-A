@extends('layouts.main')

@section('title', 'Student List')
@section('content')
<h1>Student List</h1>

<div class="alert alret-success"> New Student Added Success</div>
<a href="{{url('/student/create')}}" class=" btn btn-primary">Add new Student</a>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone No</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <th scope="row">{{$student -> id}}</th>
            <td>{{$student -> name}}</td>
            <td>{{$student -> email}}</td>
            <td>{{$student -> phone}}</td>
            <td>{{$student -> created_at -> format('y-F-d')}}</td>
            <td>{{$student -> updated_at -> diffForHumans()}}</td>
            <td>
                <div>
                    <a href="{{url('/student/edit/'. $student->id)}}" class=" btn btn-primary">Edit</a>
                    <a href="{{url('/student/delete/'. $student->id)}}" class=" btn btn-danger">Delete</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection