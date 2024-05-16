@extends('layouts.main')

@section('title', 'Student List')
@section('content')
<h1>Student List</h1>

@if (Session::has('msg'))
    <div class="alert alret-success">{{session::get('msg')}}</div>
@endif

<a href="{{url('/student/create')}}" class=" btn btn-primary">Add new Student</a>


<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone No</th>
            <th scope="col">Status</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($students as $student)
        <tr>
            <th scope="row">{{$student -> id}}</th>
            <td>{{$student -> name}}</td>
            <td>{{$student -> email}}</td>
            <td>{{$student -> phone}}</td>
            <td>{{$student -> getStatus() }}</td>
            <td>{{$student -> created_at -> format('y-F-d')}}</td>
            <td>{{$student -> updated_at -> diffForHumans()}}</td>
            <td>
                <div>
                    <a href="{{route('student.view', [$student->id])}}" class=" btn btn-primary">View</a>
                    <a href="{{url('/student/edit/'. $student->id)}}" class=" btn btn-primary">Edit</a>
                    <form action="{{url('/student/delete/'. $student->id)}}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No students found</td>
        </tr>
        @endforelse 
    </tbody>
</table>

{{ $students->links()}}
@endsection