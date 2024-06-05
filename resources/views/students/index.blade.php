@extends('layouts.main')

@section('title', 'Student List')
@section('content')
<h1 class="py-4">Student List</h1>

@if (Session::has('msg'))
<div class="alert alret-success">{{session::get('msg')}}</div>
@endif

<div class="row py-2">
    <div class="col">
        <a href="{{url('/student/create')}}" class=" btn btn-primary">Add new Student</a>
    </div>
    <div class="col text-end">
        <form action="{{ url('/student')}}" method="GET">
            <input type="text" class="form-control" name="search" placeholder="Search Name or Email" value="{{ request() -> search}}">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Search</button>
        </form>
        <div class="dropdown ">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Status Filter
            </button>
            <!-- {{request()->fullUrlWithQuery(['status' => 'all', 'page' => null, 'search' => null])}} -->
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ url('/student') }}?search={{ request()->search }}&status=all">All</a></li>
            <li><a class="dropdown-item" href="{{ url('/student') }}?search={{ request()->search }}&status=active">Active</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'inactive', 'page' => null])}}">Inactive</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'suspend', 'page' => null])}}">Suspend</a></li>
            </ul>
        </div>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone No</th>
            <th scope="col">Status</th>
            <th scope="col">Subjects</th>
            <th scope="col">Total Payment</th>
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
            <td>
                @foreach($student -> subjects  as $subject)
                    {{$subject->name}}
                @endforeach
            </td>
            <td>{{$student -> totalPayments() }}</td>
            <td>{{$student -> created_at -> format('y-F-d')}}</td>
            <td>{{$student -> updated_at -> diffForHumans()}}</td>
            <td>
                <div>
                    <a href="{{route('student.view', [$student->id])}}" class=" btn btn-primary">View</a>
                    <a href="{{route('student.payment', [$student->id])}}" class=" btn btn-dark">Payment</a>
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
            <td colspan="8">No students found</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $students->appends(request()->input())->links()}}
@endsection