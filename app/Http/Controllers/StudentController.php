<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Mail\PaymentSuccess;
use Illuminate\Http\Request;
use App\Models\StudentSubject;
use Illuminate\Support\Facades\Mail;

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
                'status' => "required",
                'subjects' => "required|array"
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'phone.required' => 'Phone is required',
                'status.required' => 'Status is required',
                'subjects.required' => "Please select atleast one subject",
            ]
        );
        $student = new Student();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->status = $request->status;
        $student->save();

        foreach ($request->subjects as $subject) {
            $studentSubject = new StudentSubject();
            $studentSubject->student_id = $student->id;
            $studentSubject->name = $subject;
            $studentSubject->save();
        }
        return redirect('/student')->with(['msg' => 'New Student Added Successfully']);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $studentSubjects = StudentSubject::where('student_id', $id)->pluck('name')->toArray();
        return view('students.edit', compact('student' , 'studentSubjects'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'name' => "required",
                'email' => "required|email",
                'phone' => "required|unique:students,phone," . $id,
                'status' => "required",
                'subjects' => "required|array",
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'phone.required' => 'Phone is required', 
                'subjects.required' => "Please select at least one subject",
            ]
        );

        $student = Student::find($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->status = $request->status;
        $student->save();

        StudentSubject::where('student_id', $id)->delete(); // Remove old subjects
        foreach ($request->subjects as $subject) {
            $studentSubject = new StudentSubject();
            $studentSubject->student_id = $student->id;
            $studentSubject->name = $subject;
            $studentSubject->save();
    }

        return redirect('/student');
    }

    public function delete($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->payments()->delete();
            $student->subjects()->delete();
            $student->delete();
        }
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

        

        //send email

        //send the mail immediately
        // Mail::to('ishansenanayaka1@gmail.com')->send(new PaymentSuccess($request->payment, $payment->student->name));
        Mail::to('ishansenanayaka1@gmail.com')->send(new PaymentSuccess($payment));

        //send the mail in the queue
        // Mail::to('ishansenanayaka1@gmail.com')->queue(new PaymentSuccess($request->payment, $payment->student->name)); 

        //send sms
        $text = urlencode("This is an example message");
        $to = "94724860510";

        // $this->sendSMS($to, $text);
        return redirect('/student');
    }

    public function sendSMS($to, $text){
        $user = config('services.textitbiz.username');
        $password = config('services.textitbiz.password');

        $baseurl = "http://www/textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = file($url);
    }
}
