<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query()->orderBy('id', 'desc');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $students->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->has('status')) {
            $status = $request->status;
            if ($status === 'inactive') {
                $students->where('status', 0);
            } else if ($status === 'suspend') {
                $students->where('status', 2);
            } else if ($status === 'active') {
                $students->where('status', 1);
            }
        }
        $students = $students->paginate(10);

        return view('students.index', compact('students'));
    }


    public function create()
    {
        return view('students.create');
    }
    public function save(Request $request)
    {
        $request->validate(
            [
                'name' => "required",
                'email' => "required|email",
                'phone' => "required|unique:students,phone",
                'status' => "required"
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'phone.required' => 'Phone is required',
                'status.required' => 'Status is required'
            ]
        );
        $student = new Student();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->status = $request->status;
        $student->save();

        return redirect('/student')->with(['msg' => 'New Student Added Successfully']);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'name' => "required",
                'email' => "required|email",
                'phone' => "required|unique:students,phone," . $id,
                'status' => "required"
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'phone.required' => 'Phone is required'
            ]
        );

        $student = Student::find($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->status = $request->status;
        $student->save();
        return redirect('/student');
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
        return redirect('/student');
    }

    public function view($id)
    {
        $student = Student::find($id);

        return view('students.view', compact('student'));
    }

    public function payment($id)
    {
        $student = Student::find($id);
        return view('students.payment', compact('student'));
    }

    public function savePayment(Request $request, $id)
    {
        $request->validate(
            [
                'payment' => "required|numeric|min:0.01",
            ],
            [
                'payment.required' => 'Payment is required',
            ]
        );
        $payment = new Payment();

        $payment->student_id = $id;
        $payment->amount = $request->payment;
        $payment->save();
        return redirect('/student');
    }
}
