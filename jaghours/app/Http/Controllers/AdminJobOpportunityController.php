<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOportunity;
use App\Enums\JobOportunityStatus;

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

    public function update(Request $request, string $id)
    {
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
            $jobOpportunity = JobOportunity::findOrFail($id);
            $jobOpportunity->update($request->all());

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
