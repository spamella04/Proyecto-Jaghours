<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;
use Exception;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $degrees = Degree::all()->sortBy('code');
            return view('degrees.index', compact('degrees'));
        } catch (\Exception $e) {
            return redirect()->route('degrees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        try{
            return view('degrees.create');
        } catch (\Exception $e) {
            return redirect()->route('degrees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
            $degree = new Degree();
            $degree->code = $request->code;
            $degree->name = $request->name;
            $degree->save();
            return redirect()->route('degrees.index')->with('success', 'Carrera Creada Exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('degrees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $degree = Degree::find($id);
            return view('degrees.show', compact('degree'));
        } catch (\Exception $e) {
            return redirect()->route('degrees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try{
            $degree = Degree::find($id);
            return view('degrees.edit', compact('degree'));
        } catch (\Exception $e) {
            return redirect()->route('degrees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{
            $degree = Degree::find($id);
            $degree->code = $request->code;
            $degree->name = $request->name;
            $degree->save();
            return redirect()->route('degrees.index')->with('success', 'Carrera Actualizada Exitosamente');
        }catch (\Exception $e) {
                return redirect()->route('degrees.index')->with('error', $e->getMessage());
            }
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $degree = Degree::find($id);
            $degree->status = 'inactive';
            $degree->save();
            return redirect()->route('degrees.index')->with('success', 'Carrera Eliminada Exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('degrees.index')->with('error', $e->getMessage());
        }
    }

    public function notdestroy(string $id)
    {
        //
        try{
            $degree = Degree::find($id);
            $degree->status = 'active';
            $degree->save();
            return redirect()->route('degrees.index')->with('success', 'Carrera Eliminada Exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('degrees.index')->with('error', $e->getMessage());
        }
    }
}
