<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOportunity;
use App\Enums\JobOportunityStatus;
use App\Models\Area;
use App\Models\AreaManager;

class AdminJobOpportunityController extends Controller
{
    public function index()
    {
        try {
            $jobOpportunities = JobOportunity::where('status', 'Solicitud')->get();
            return view('adminjobopportunities.index', compact('jobOpportunities'));
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }

    

    public function allJobOpportunities(Request $request)
{
    // Obtener los parámetros de búsqueda
    $searchTerm = $request->input('search_term'); // Búsqueda por título
    $areaId = $request->input('area_id'); // Filtro por área
    $status = $request->input('status'); // Filtro por estado

    // Consultar las oportunidades de trabajo, excluyendo "Solicitud"
    $jobOportunities = JobOportunity::where('status', '!=', 'Solicitud')
        ->when($searchTerm, function ($query, $searchTerm) {
            return $query->where('title', 'like', "%{$searchTerm}%"); // Buscar por título
        })
        ->when($areaId, function ($query, $areaId) {
            return $query->whereHas('area_managers.areas', function ($query) use ($areaId) {
                $query->where('area_id', $areaId);
            });
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->with('area_managers.areas') // Traer las áreas relacionadas
        ->paginate(10); // Paginación para los resultados

    // Traer los estados y áreas para los dropdowns
    $areas = Area::all();  // Obtener todas las áreas disponibles
    $states = JobOportunity::distinct()->pluck('status'); // Obtener todos los estados únicos disponibles (sin incluir "Solicitud")

    return view('adminjobopportunities.allJobOpportunities', compact('jobOportunities', 'areas', 'states'));
}

    public function editJobOpportunity(string $id){

        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            return view('adminjobopportunities.editJobOpportunity', compact('jobOpportunity'));
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.allJobOpportunities');
        }
        
    }

    public function saveChanges(Request $request, JobOportunity $jobOpportunity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'hours_validated' => 'required|integer|min:' . $jobOpportunity->hours_validated,
            'number_applicants' => 'required|integer|min:' . $jobOpportunity->number_applicants,
            'number_vacancies' => 'required|integer|min:' . $jobOpportunity->number_vacancies,
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'requirements' => 'required|string',
        ], [
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'hours_validated.min' => 'Las horas convalidadas no pueden ser menores que el valor actual.',
            'number_applicants.min' => 'El número de aplicantes no puede ser menor que el valor actual.',
            'number_vacancies.min' => 'El número de vacantes no puede ser menor que el valor actual.',
        ]);
    
        try {
            // Manejo de la imagen
            $imagePath = $jobOpportunity->image_path;
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/images'), $imageName);
                $imagePath = 'assets/images/' . $imageName;
            }
    
            // Actualizar los campos del trabajo
            $jobOpportunity->title = $request->title;
            $jobOpportunity->description = $request->description;
            $jobOpportunity->start_date = $request->start_date;
            $jobOpportunity->hours_validated = $request->hours_validated;
            $jobOpportunity->number_applicants = $request->number_applicants;
            $jobOpportunity->number_vacancies = $request->number_vacancies;
            $jobOpportunity->image_path = $imagePath;
            $jobOpportunity->requirements = $request->requirements;
    
            // Guardar los cambios
            $jobOpportunity->save();
    
            return redirect()->route('adminjobopportunities.allJobOpportunities')
                ->with('success', 'La solicitud se ha actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.allJobOpportunities')
                ->with('error', 'Hubo un problema al actualizar la solicitud: ' . $e->getMessage());
        }
    }
    

    
    public function create()
    {
        try {
            return view('adminjobopportunities.create');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index');
        }
    }

    public function store(Request $request)
    {
        // Validar y guardar nueva oportunidad
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date',
            'hours_validated' => 'required|integer',
            'number_applicants' => 'required|integer',
            'number_vacancies' => 'required|integer',
            'requirements' => 'nullable|string|max:1000'
        ]);

        JobOportunity::create($request->all());

        return redirect()->route('adminjobopportunities.index')->with('success', 'Oportunidad de trabajo creada correctamente.');
    }

    public function show(string $id)
    {
        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            return view('adminjobopportunities.show', compact('jobOpportunity'));
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index');
        }
    }

    public function edit(string $id)
    {
        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            return view('adminjobopportunities.edit', compact('jobOpportunity'));
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date',
            'hours_validated' => 'required|integer',
            'number_applicants' => 'required|integer',
            'number_vacancies' => 'required|integer',
            'requirements' => 'nullable|string|max:1000'
        ]);

        try {
            // Encontrar la oportunidad de trabajo
            $jobOpportunity = JobOportunity::findOrFail($id);

            // Actualizar los campos
            $jobOpportunity->title = $request->title;
            $jobOpportunity->description = $request->description;
            $jobOpportunity->start_date = $request->start_date;
            $jobOpportunity->hours_validated = $request->hours_validated;
            $jobOpportunity->number_applicants = $request->number_applicants;
            $jobOpportunity->number_vacancies = $request->number_vacancies;
            $jobOpportunity->requirements = $request->requirements;

            // Guardar los cambios
            $jobOpportunity->save();

            return redirect()->route('adminjobopportunities.index')->with('success', 'La solicitud se ha actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index')->with('error', 'Hubo un problema al actualizar la solicitud.');
        }
       
    }

    public function publish(string $id)
    {
        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            $jobOpportunity->status = JobOportunityStatus::Published;
            $jobOpportunity->save();
            return redirect()->route('adminjobopportunities.index');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index');
        }
    }

    public function reject(string $id)
    {
        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            $jobOpportunity->status = JobOportunityStatus::Rejected;
            $jobOpportunity->save();
            return redirect()->route('adminjobopportunities.index');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index');
        }
    }

    public function active(string $id){

        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            $jobOpportunity->status = JobOportunityStatus::Published;
            $jobOpportunity->save();
            return redirect()->route('adminjobopportunities.allJobOpportunities');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index');
        }
      
    }

    public function inactive(string $id)
    {
        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            $jobOpportunity->status = JobOportunityStatus::Inactive;
            $jobOpportunity->save();
            return redirect()->route('adminjobopportunities.allJobOpportunities');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index');
        }
    }

    

    public function destroy(string $id)
    {
        try {
            $jobOpportunity = JobOportunity::findOrFail($id);
            $jobOpportunity->delete();
            return redirect()->route('adminjobopportunities.index')->with('success', 'Oportunidad de trabajo eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('adminjobopportunities.index')->with('error', 'Hubo un problema al eliminar la oportunidad de trabajo.');
        }
    }
}
