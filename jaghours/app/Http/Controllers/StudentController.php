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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;


class StudentController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student');
        
        // Aplicar búsqueda si existe
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($query) use ($search) {
                $query->where('cif', '=', $search)
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%");
            });
        }
    
        // Mostrar todos los estudiantes si el parámetro 'show_all' está presente
        if (!$request->filled('show_all')) {
            $query->where('status', 'active');
        }
        
        $users = $query->get();
        
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


    public function showJobs(Request $request)
    {
        $student = Auth::user()->student;
    
        if (!$student) {
            return redirect()->route('home')->with('error', 'No tienes un perfil de estudiante asociado.');
        }
    
        $userCreatedDate = Auth::user()->created_at;

    // Filtrar semestres donde el `end_date` sea menor que el `created_at` del usuario
    $semesters = Semester::where('end_date', '>=', $userCreatedDate)->get();
    
        // Inicializar variables
        $semesterProgress = null;
    
        if ($request->filled('semester_id')) {
            $semester_id = $request->input('semester_id');
            $semester = Semester::find($semester_id);
    
            if ($semester) {
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
                $percentage = $requiredHours > 0 ? ($totalHoursWorked / $requiredHours) * 100 : 0;
    
                // Almacenar el progreso del semestre
                $semesterProgress = [
                    'semester' => $semester,
                    'totalHoursWorked' => $totalHoursWorked,
                    'requiredHours' => $requiredHours,
                    'percentage' => $percentage,
                    'hourRecords' => $hourRecords,
                ];
            }
        }
    
        return view('student.jobs', compact('semesters', 'semesterProgress'));
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
            $user->status = 'inactive';
            $user->save();
            return redirect()->route('students.index');
        }
        catch(\Exception $e){
            return redirect()->route('students.index');
        }
    }

    public function notdestroy(string $id)
    {
        //
        try{
            $user = User::find($id);
            $user->status = 'active';
            $user->save();
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
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $import= new StudentsImport;
        Excel::import($import, $request->file('file'));

   

        // Obtener el número de estudiantes ignorados
        $ignoredCount = $import->getIgnoredCount();

        // Retornar el mensaje con el número de estudiantes importados e ignorados
        if ($ignoredCount > 0) {
            return back()->with('success', "Students imported successfully! {$ignoredCount} students were skipped because they already exist.");
        }

        return back()->with('success', 'Students imported successfully!');
    }

    
}
