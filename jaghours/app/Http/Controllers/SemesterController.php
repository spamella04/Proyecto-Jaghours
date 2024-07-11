<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use Exception;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $semesters = Semester::all()->sortBy('start_date');
            return view('semesters.index', compact('semesters'));
        } catch (\Exception $e){
            return redirect()->route(semesters.index)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        try{
            return view('semesters.create');
        } catch (\Exception $e){
            return redirect()->route('semesters.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'hours_required' => 'required|integer|min:1',
        ]);
        
        try{
            $semester = new Semester();
            $semester->name = $request->name;
            $semester->start_date = $request->start_date;
            $semester->end_date = $request->end_date;
            $semester->hours_required = $request->hours_required;
            $semester->save();
            return redirect()->route('semester.index')->with('success', 'Semestre Creado Exitosamente');
        } catch (\Exception $e){
            return redirect()->route('semesters.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $semester = Semester::find($id);
            return view('semesters.show', compact('semester'));
        } catch (\Exception $e){
            return redirect()->route('semesters.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try{
            $semester = Semester::find($id);
            return view('semesters.edit', compact('semester'));
        } catch (\Exception $e){
            return redirect()->route('semesters.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{
            $semester = Semester::find($id);
            $semester->name = $request->name;
            $semester->start_date = $request->start_date;
            $semester->end_date = $request->end_date;
            $semester->hours_required = $request->hours_required;
            $semester->save();
            return redirect()->route('semesters.index')->with('success', 'Semestre Actualizado Exitosamente');
        } catch (\Exception $e){
            return redirect()->route('semesters.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $semester = Semester::find($id);
            $semester->delete();
            return redirect()->route('semesters.index')->with('success', 'Semestre Eliminado Exitosamente');
        } catch (\Exception $e){
            return redirect()->route('semesters.index')->with('error', $e->getMessage());
        }
    }
}
