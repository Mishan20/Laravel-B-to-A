@extends('layouts.main')

@section('title', 'Student View')

@section('content')
    {{ $student->name}}
@endsection