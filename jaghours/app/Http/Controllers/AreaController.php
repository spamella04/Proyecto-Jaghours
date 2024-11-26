<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        try {
            $search = $request->input('search');

            if ($search) {
                $areas = Area::where('code', '=', $search)
                    ->orWhere('name', 'like', "%{$search}%")
                    ->paginate(10);
            } else {
                $areas = Area::orderBy('code')->paginate(10);
            }

            return view('areas.index', compact('areas'));
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        try {
            return view('areas.create');
        }catch(\Exception $e){
            return redirect()->route('home');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $area = new Area();
            $area->code = $request->code;
            $area->name = $request->name;
            $area->description = $request->description;
            $area->save();
            return redirect()->route('areas.index');
        }catch(\Exception $e){
            return redirect()->route('areas.create');
        }
    
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $area = Area::find($id);
                return view('areas.show', compact('area'));
        } catch(\Exception $e){
            return redirect()->route('areas.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $area = Area::find($id);
            return view('areas.edit', compact('area'));
        }catch(\Exception $e){
            return redirect()->route('areas.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{
            $area = Area::find($id);
            $area->code = $request->code;
            $area->name = $request->name;
            $area->description = $request->description;
            $area->save();
            return redirect()->route('areas.index');
        }catch(\Exception $e){
            return redirect()->route('areas.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $area = Area::find($id);
            $area->status='inactive';
            $area->save();
            return redirect()->route('areas.index');
        }
        catch(\Exception $e){
            return redirect()->route('areas.index');
        }
    }

    public function notdestroy(string $id)
    {
        //
        try{
            $area = Area::find($id);
            $area->status='active';
            $area->save();
            return redirect()->route('areas.index');
        }
        catch(\Exception $e){
            return redirect()->route('areas.index');
        }
    }
}
