<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    { 
        if ($request->status == 'all'){
            $students = Student::orderBy('id', 'desc')->paginate(10);
        } elseif ($request->status == 'inactive'){
            $students = Student::where('status', '=', 0)->orderBy('id', 'desc')->paginate(10);
        } elseif ($request->status == 'suspend'){
            $students = Student::where('status', '=', 2)->orderBy('id', 'desc')->paginate(10);
        } else {
            $students = Student::where('status', '=', 1)->orderBy('id', 'desc')->paginate(10);
        }
        return view('students.index', compact('students'));
    }

    public function create(){
        return view('students.create');
    }
    public function save(Request $request)
    {
        $request ->validate([
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
    
       return redirect('/student') -> with(['msg' => 'New Student Added Successfully']);
    }

    public function edit($id){
        $student = Student::find($id);
 
        return view('students.edit', compact('student'));
        
    }

    public function update(Request $request, $id)
    {

        $request ->validate([
            'name' => "required",
            'email' => "required|email",
            'phone' => "required|unique:students,phone," .$id,
            'status' => "required"
        ],
        [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'phone.required' => 'Phone is required'
        ]);

        $student = Student::find($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->status = $request->status;
        $student->save();
        return redirect('/student');
    }

    public function delete($id){
        $student = Student::find($id);
        $student->delete();
        return redirect('/student');
    }

    public function view($id){
        $student = Student::find($id);
 
        return view('students.view', compact('student'));
    }
}