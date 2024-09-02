<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaManager;
use App\Models\User;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;

class AreaManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtener el término de búsqueda
            $search = $request->input('search');
    
            // Consultar los usuarios con el rol 'areamanager' y aplicar el filtro de búsqueda si existe
            $users = User::where('role', 'areamanager')
                ->when($search, function ($query, $search) {
                    return $query->where(function ($query) use ($search) {
                        $query->where('cif', '=', $search)
                              ->orWhere('name', 'like', "%{$search}%")
                              ->orWhere('lastname', 'like', "%{$search}%")
                              ->orWhereHas('area_manager.areas', function ($query) use ($search) {
                                  $query->where('name', 'like', "%{$search}%");
                              });
                    });
                })
                ->with('area_manager.areas')
                ->get();
    
            return view('areamanagers.index', compact('users', 'search'));
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $areas= Area::all();
            return view('areamanagers.create', compact('areas'));
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
              // Validación de datos
              $request->validate([
                'cif' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:8',
                'area_id' => 'required|exists:areas,id',
                ]); 
                
                $user = new User();
                $user->name = $request->name;
                $user->cif = $request->cif;
                $user->lastname = $request->lastname;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = Hash::make($request->password);
                $user->role= 'areamanager';
                $user->save();

                  // Asociar como Representante de Area
            $user->area_manager()->create([
                'area_manager_id' => $user->id, 
                'area_id' => $request->area_id,
            ]);
            
            return redirect()->route('areamanagers.index')->with('success', '¡Usuario creado con éxito!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $user = User::find($id);
            return view('areamanagers.show', compact('user'));
        } catch(\Exception $e){
            return redirect()->route('areamanagers.index');
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $user = User::find($id);
            $areas = Area::all();
            return view('areamanagers.edit', compact('user', 'areas'));
        }catch(\Exception $e){
            return redirect()->route('areamanagers.index');
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
            if($request->password){
                $user->password = Hash::make($request->password);
                $user->save();
            }
            $user->role = 'areamanager';
            $user->save();
            $areaManager = $user->area_manager;
            if($areaManager){

                $areaManager->area_id = $request->area_id;
                $areaManager->save();
            }
            return redirect()->route('areamanagers.index');
        }catch(\Exception $e){
            return redirect()->route('areamanagers.edit', $id);
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
            $user->status='inactive';
            $user->save();
            return redirect()->route('areamanagers.index');
        }catch(\Exception $e){
            return redirect()->route('areamanagers.index');
        }
    }

    public function notdestroy(string $id)
    {
        //
        
            $user = User::find($id);
            $user->status='active';
            $user->save();
            return redirect()->route('areamanagers.index');
        
    }
}
