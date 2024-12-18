<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOportunity;
use App\Enums\JobOportunityStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\AreaManager;
use App\Models\Area;
use App\Models\Student;
use App\Models\Application;
use App\Models\Job;
use App\Decorator\Applications\MatchApplicationHandler;
use App\Decorator\Applications\RegularApplicationHandler;
use Illuminate\Support\Facades\DB;
use App\Decorators\StudentDecorator;
use App\Models\Semester;
use Illuminate\Contracts\Encryption\DecryptException;


class JobOportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'areamanager') {
            $areaManager = Auth::user()->area_manager;

            if ($areaManager) {
                $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)
                ->where('status', 'Solicitud')
                ->paginate(4);
                return view('joboportunity.index', compact('jobOportunities'));
            }
        }

        if (Auth::user()->role == 'admin') {
            $admin = Auth::user()->role=='admin';
            if ($admin) {
                $jobOportunities = JobOportunity::with('applications.student')->where('status', 'Publicado')->paginate(4);
                return view('joboportunity.index', compact('jobOportunities'));
            }
        }

        return redirect()->route('home'); // Redirigir a una página de inicio o de error si el usuario no es un area manager
    }

    

    public function indexAreaManager()
    {
        if (Auth::user()->role == 'areamanager') {
            $areaManager = Auth::user()->area_manager;

            if ($areaManager) {
                $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)
                ->where('match', 0)
                ->paginate(4);
                return view('joboportunity.indexAreaManager', compact('jobOportunities'));
            }
        }


        return redirect()->route('home'); // Redirigir a una página de inicio o de error si el usuario no es un area manager
    }

    public function indexStudent(Request $request)
    {
        if (Auth::user()->role == 'student') {
            $student = Auth::user()->student;
            if ($student) {
                // Obtener los IDs de las oportunidades a las cuales el estudiante ha aplicado
                $appliedOpportunityIds = $student->applications()->pluck('job_opportunity_id')->toArray();
    
                // Obtener el área seleccionada desde el request
                $areaFilter = $request->input('area');
    
                // Obtener las oportunidades publicadas que el estudiante no ha aplicado aún
                $jobOportunities = JobOportunity::where('status', 'Publicado')
                    ->whereNotIn('id', $appliedOpportunityIds)
                    ->where(function ($query) use ($areaFilter) {
                        if ($areaFilter) {
                            // Filtrar por área si se ha seleccionado un área
                            $query->whereHas('area_managers', function ($subQuery) use ($areaFilter) {
                                $subQuery->whereHas('areas', function ($subSubQuery) use ($areaFilter) {
                                    $subSubQuery->where('name', $areaFilter);
                                });
                            });
                        }
                    })
                    ->paginate(4);
    
                // Obtener todas las áreas para el filtro dropdown
                $areas = Area::all();
    
                return view('joboportunity.indexStudent', compact('jobOportunities', 'areas'));
            }
        }
    
        return redirect()->route('home'); // Redirigir si el usuario no es un estudiante o no tiene aplicaciones
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('joboportunity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'hours_validated' => 'required|integer|min:1',
            'number_applicants' => 'required|integer|min:1',
            'number_vacancies' => 'required|integer|min:1',
            'requirements' => 'required|string',
            'match' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación de la imagen
            
            
        ], [
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'hours_validated.min' => 'Las horas convalidadas deben ser al menos 1.',
            'number_applicants.min' => 'El número de aplicantes debe ser al menos 1.',
            'number_vacancies.min' => 'El número de vacantes debe ser al menos 1.',
        ]);
        //Validar si se ha subido una imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Cambiamos la ruta de almacenamiento a 'assets/images'
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images'), $imageName);
            $imagePath = 'assets/images/' . $imageName; // Guarda la ruta completa
            $validated['image_path'] = $imagePath; // Asigna la ruta a validated['image_path']
        }
        
        
        $area_manager= Auth::user()->area_manager;

        $jobOportunity = new JobOportunity();
        $jobOportunity->title = $request->title;
        $jobOportunity->description = $request->description;
        $jobOportunity->start_date= $request->start_date;
        $jobOportunity->hours_validated = $request->hours_validated;
        $jobOportunity->number_applicants = $request->number_applicants;
        $jobOportunity->number_vacancies = $request->number_vacancies;
        $jobOportunity->requirements = $request->requirements;
        $jobOportunity->area_manager_id = $area_manager->id;
        $jobOportunity->match = $request->has('match');
        $jobOportunity->image_path = $imagePath;
        $jobOportunity->save();
        return redirect()->route('joboportunity.index');
        
    }

    public function directEntry()
    {
        
        return view('directjobopportunity.directEntry');
    }

    public function storeDirectJobOpportunity(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'hours_validated' => 'required|integer|min:1',
        'numero_estudiantes' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación de la imagen
    ]);

    // Validar si se ha subido una imagen
    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images'), $imageName);
        $imagePath = 'assets/images/' . $imageName;
    }

    $jobOportunity = new JobOportunity();
    $jobOportunity->title = $request->title;
    $jobOportunity->description = $request->description;
    $jobOportunity->start_date = now();
    $jobOportunity->hours_validated = $request->hours_validated;
    $jobOportunity->number_applicants = $request->numero_estudiantes;
    $jobOportunity->number_vacancies = $request->numero_estudiantes;
    $jobOportunity->requirements = "No se requiere";
    $jobOportunity->status = 'Asignacion Directa';
    $adminAreaManagerId = 1; // ID del Administrador del Sistema
    $jobOportunity->area_manager_id = $adminAreaManagerId;
    $jobOportunity->match = false;
    $jobOportunity->image_path = $imagePath;
    $jobOportunity->save();

    return redirect()->route('directjobopportunity.addStudents', ['jobOpportunityId' => $jobOportunity->id]);

}

    public function showDirectJobOpportunity(Request $request, $id )

    {
         
        try	{
            $jobOportunity = JobOportunity::findOrFail($id);

            // Obtener semestres
            $semesters = Semesters::where('status', 'active')->get();
        
            // Obtener estudiantes según criterio de búsqueda (si existe un filtro)
            $search = $request->get('search'); // El término de búsqueda viene del frontend
            $students = Student::when($search, function ($query, $search) {
                return $query->where('cif', 'LIKE', "%{$search}%") // Filtra por CIF
                             ->orWhere('name', 'LIKE', "%{$search}%"); // Filtra por nombre (opcional)
            })->get();
        
            return view('directjobopportunity.show', compact('jobOportunity', 'semesters', 'students'));
        } catch (\Exception $e) {
            return redirect()->route('job.index');
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function showApplicants(Request $request,$id)
    {
        
        $joboportunity = JobOportunity::with('applications.student.user')->findOrFail($id);
        $query = Application::query()->where('job_opportunity_id', $id);
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student.user', function ($query) use ($search) {
                $query->where('cif', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%");
            });
        }
    
        // Obtener las aplicaciones (filtradas si aplica)
        $applications = $query->get();

        // Usar el decorador correspondiente basado en el valor de match
        if ($joboportunity->match) {

            $joboportunityId = JobOportunity::findOrFail($id);
            $handler = new MatchApplicationHandler($applications, $joboportunityId);
        } else {
            $handler = new RegularApplicationHandler($applications);
        }
    
        $applicationsTable = $handler->render(); // Renderizar la tabla de aplicaciones
    
        return view('joboportunity.showapplicants', compact('applicationsTable', 'joboportunity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'hours_validated' => 'required|integer|min:1',
            'number_applicants' => 'required|integer|min:1',
            'number_vacancies' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación de la imagen
            'requirements' => 'required|string',
        ], [
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'hours_validated.min' => 'Las horas convalidadas deben ser al menos 1.',
            'number_applicants.min' => 'El número de aplicantes debe ser al menos 1.',
            'number_vacancies.min' => 'El número de vacantes debe ser al menos 1.',
        ]);
        try{

            $imagePath = null;
            if ($request->hasFile('image')) {
                // Cambiamos la ruta de almacenamiento a 'assets/images'
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/images'), $imageName);
                $imagePath = 'assets/images/' . $imageName; // Guarda la ruta completa
                $validated['image_path'] = $imagePath; // Asigna la ruta a validated['image_path']
            }
            
            $jobOportunity = JobOportunity::findOrFail($id);
            $jobOportunity->title = $request->title;
            $jobOportunity->description = $request->description;
            $jobOportunity->start_date = $request->start_date;
            $jobOportunity->hours_validated = $request->hours_validated;
            $jobOportunity->number_applicants = $request->number_applicants;
            $jobOportunity->number_vacancies = $request->number_vacancies;
            $jobOportunity->image_path = $imagePath;
            $jobOportunity->requirements = $request->requirements;
            $jobOportunity->save();
            return redirect()->route('joboportunity.index');
        }
        catch(\Exception $e){
            return redirect()->route('joboportunity.edit');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
