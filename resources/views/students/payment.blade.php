@extends('layouts.main')

@section('title', 'Payment Student')
@section('content')
<h1>Add Student Payment</h1>
<a href="{{url('/student')}}" class="btn btn-primary">Back to Student List</a>
<form method="POST" action="{{ url('/student/payment/'. $student->id)}}">
    <input type="hidden" payment="_token" value="{{ csrf_token() }}" />
    <div class=" mb-3">
        <label for="payment" class="form-label">Price</label>
        <input value="{{old('payment')}}" type="text" class="@error('payment') is-invalid @enderror form-control" id="payment" name="payment" aria-describedby="">
        @error('payment')
        <div class="color-red text-sm">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection