<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class ApiAdminController extends Controller
{
    
    public function signup(Request $request)
    {
        if (!$request->has(['email', 'password'])) {
            return response()->json(['error' => 'Email and password are required.'], 400);
        }
        
        
        $email = $request->input('email');
        $password = $request->input('password');
        
        $user = User::where('email', $email)->first();
        if($user ){
            return response()->json(['error' => 'User is already registered.'], 404);
        }
        
        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password), 
        ]);
       
        return response()->json(['success'=>'User created succesfully'], 200);
    }
    public function login(Request $request)
    {
        if (!$request->has(['email', 'password'])) {
            return response()->json(['error' => 'Email and password are required.'], 400);
        }
       
    
        $email = $request->input('email');
        $password = $request->input('password');
    
        // Check if the user with the given email exists
        $user = User::where('email', $email)->first();
    
        if (!$user) {
        
            return response()->json(['error' => 'User is not registered.'], 404);

        }  
     
        if (password_verify($password, $user->password)) {
           
            return response()->json(['success' => 'Logged in successfully'], 200);
        } else {
           
            return response()->json(['error' => 'Wrong password.'], 401);
        }
    }



    public function insertTeacher(Request $request)
{
    
    $request->validate([
        'teacher_name' => 'required|string',
        'contact_number' => 'required|string',
        'department_id' => 'required|string',   
    ]);

    $teacher = new Teacher();
    $teacher->teacher_name = $request->input('teacher_name');
    $teacher->contact_number = $request->input('contact_number');
    $teacher->department_id =  (int)$request->input('department_id');   //here we are converting the string input to integer
    
    $teacher->save();

    
    return response()->json(['message' => 'Teacher inserted successfully'], 200);
}

    public function deleteTeacher($id)
    {
        $teacher = Teacher::find($id);

        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully'], 200);
    }

    public function updateTeacher(Request $request, $id)
    {
        $request->validate([
            'teacher_name' => 'required|string',
            'contact_number' => 'required|string',
            
        ]);

        $teacher = Teacher::find($id);

       

        $teacher->update([
            'teacher_name' => $request->teacher_name,
            'contact_number' => $request->contact_number,
            
        ]);

        return response()->json(['message' => 'Teacher updated successfully'], 200);
    }

    public function insertDepartment(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string',
            'hod' => 'required|string',
        ]);
    
       
        $department = new Department();
        $department->department_name = $request->input('department_name');
        $department->hod = $request->input('hod');
        $department->save();
    

    
        // return response()->json(['department'=>$department], 201);
        return response()->json(['message'=>"department inserted successfully"], 200);

    }
    

    public function deleteDepartment($id)
    {
        $department = Department::find($id);

        $department->delete();

        return response()->json(['message' => 'Department deleted successfully'], 200);
    }

    public function updateDepartment(Request $request, $id)
{
    $request->validate([
        'department_name' => 'required|string',
        'hod' => 'required|string',
    ]);

    $department = Department::find($id);

    $department->update([
        'department_name' => $request->department_name,
        'hod' => $request->hod
    ]);

    return response()->json(['message' => 'Department updated successfully'], 200);
}

    public function assignHod(Request $request, $department_name)
    {
        $request->validate([
            'hod' => 'required|string',
        ]);

        $department = Department::where('department_name', $department_name)->first();

        $department->update([
            'hod'=> $request->hod
        ]);

    return response()->json(['message'=>"HOD is assigned successfully to the department"], 200);



    }


}
