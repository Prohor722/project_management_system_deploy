<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::paginate(5);
        // return $teachers;
        return view('admin.teachers',["teachers"=>$teachers]);
    }

    public function create()
    {
        return view('admin.addTeacher');
    }

    public function store(Request $request)
    {
        $request->validate([
            't_id'=>"required|unique:teachers",
            't_name'=>"required",
            'department'=>'required',
            'email'=>"required|unique:teachers",
            'password'=>'required|min:4',
            'confirm_password'=>'required|same:password',
        ]);

        Teacher::create($request->all());

        return redirect('/admin/teacher');
    }

    public function show(Teacher $teacher, Request $request)
    {
        $teachers = Teacher::all();
        return view("admin.editTeacher", ["teachers"=>$teachers, "teacher"=>$teacher]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, Teacher $teacher)
    {
        $id = $teacher->id;

        $request->validate([
        't_id'=>['required',
            Rule::unique('teachers')->ignore($id)
            ],
        't_name'=>"required",
        'department'=>"required",
        'email'=>['required',
            Rule::unique('teachers')->ignore($id)
            ],
    ]);

        $pass = $request->password ;
        $cpass = $request->confirm_password;

        if(!$pass || ($pass !== $cpass) ){
            $request['password'] = $teacher->password;
        }
        // dd($request);
        $teacher->update($request->all());
        return redirect('/admin/teacher');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect('/admin/teacher');
    }

    public function teacherInfo($id){

        $teachers = Teacher::paginate(5);
        $teacher = Teacher::where('t_id',$id)->first();

        return view('admin.teacherInfo',['teachers'=>$teachers, 'teacher'=>$teacher]);
    }

    public function search(Request $request){

        $txt = $request->searchText;

        $search = Teacher::query()->where('t_id', 'LIKE', "%{$txt}%")
        ->orWhere('t_name', 'LIKE', "%{$txt}%")
        ->paginate(5)->withQueryString();

        // $search = Teacher::where('t_name', $txt)->paginate(5);

        $size = count($search);
        // return $size;
        $teachers = Teacher::paginate(5);

        // return $teachers;

        if($size>1){
            return view('admin.teachers',['teachers'=>$search]);
        }

        return view('admin.teacherInfo',['teachers'=>$teachers, 'teacher'=> $search[0]]);
    }
}
