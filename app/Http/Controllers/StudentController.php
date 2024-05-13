<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create(){
        return view('students.create');
    }
    public function save(Request $request)
    {
       $student = new Student();
       
       $student->name = $request->name;
       $student->email = $request->email;
       $student->phone = $request->phone;
       $student->save();
    
       return redirect('/student') -> with(['msg' => 'New Student Added Successfully']);
    }

    public function edit($id){
        $student = Student::find($id);
 
        return view('students.edit', compact('student'));
        
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->save();
        return redirect('/student');
    }
}