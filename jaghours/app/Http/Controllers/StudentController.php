<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Degree;
use Illuminate\Support\Facades\Hash;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users=User::with('student')->get();
        $students = Student::with('degree')->get();
        return view('student.index', compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $degrees= Degree::all();
        return view('student.create', compact('degrees'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // Validación de datos
             $request->validate([
            'cif' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'degree_id' => 'required|exists:degrees,id',
            'skills' => 'required|string|max:255',
            ]); 
            
            $user = new User();
            $user->name = $request->name;
            $user->cif = $request->cif;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->role= 'student';
            $user->save();

    
            // Asociar como estudiante
            $user->student()->create([
                'student_id' => $user->id, 
                'degree_id' => $request->degree_id,
                'skills' => $request->skills
            ]);
            
            return redirect()->route('students.index')->with('success', '¡Usuario creado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('student.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return view('student.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
