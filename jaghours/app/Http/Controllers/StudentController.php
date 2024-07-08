<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Degree;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\HourRecord;
use App\Models\Semester;

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
       try {
            $user = User::find($id);
            return view('student.show', compact('user'));
        } catch(\Exception $e){
            return redirect()->route('students.index');
        }
    }


    public function showJobs()
    {
  
    
     
    $student = Auth::user()->student;

    // Obtener todos los semestres
    $semesters = Semester::all();

    // Preparar un array para almacenar el progreso de cada semestre
    $semesterProgress = [];

    foreach ($semesters as $semester) {
        // Obtener todos los registros de horas del estudiante para este semestre
        $hourRecords = HourRecord::where('semester_id', $semester->id)
            ->whereHas('job', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->get();

        // Calcular las horas totales trabajadas en este semestre
        $totalHoursWorked = $hourRecords->sum('hours_worked');

        // Calcular el porcentaje de progreso
        $requiredHours = $semester->hours_required;
        $percentage = $totalHoursWorked > 0 ? ($totalHoursWorked / $requiredHours) * 100 : 0;

        // Almacenar el progreso del semestre
        $semesterProgress[] = [
            'semester' => $semester,
            'totalHoursWorked' => $totalHoursWorked,
            'requiredHours' => $requiredHours,
            'percentage' => $percentage,
        ];
    }

    return view('student.jobs', compact('semesterProgress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $user = User::find($id);
            $degrees = Degree::all();
            return view('student.edit', compact('user', 'degrees'));
        }catch(\Exception $e){
            return redirect()->route('students.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{
            $user = User::find($id);
            $user->name = $request->name;
            $user->cif = $request->cif;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->role= 'student';
            $user->save();

            $student = $user->student;
        if ($student) {
            $student->degree_id = $request->degree_id;
            $student->skills = $request->skills;
            $student->save();
        }

            return redirect()->route('students.index');
        }catch(\Exception $e){
            return redirect()->route('students.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $user = User::find($id);
            $user->delete();
            return redirect()->route('students.index');
        }
        catch(\Exception $e){
            return redirect()->route('students.index');
        }
    }

    public function profile()
    {
        $student = Auth::user()->student()->with('user', 'degree')->first();
    
        return view('student.profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'skills' => 'required|string|max:255',
        ]);
    
        $user = Auth::user();
        $student = $user->student;
    
        // Update phone in the users table
        $user->phone = $request->phone;
        $user->save();
    
        // Update skills in the students table
        $student->skills = $request->skills;
        $student->save();
    
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }
    

    
}
