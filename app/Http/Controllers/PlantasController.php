<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Plantas;
use App\Models\User;
use Illuminate\Http\Request;

class PlantasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plantas = Plantas::all();
        if ($plantas->count() == 0){
            return response()->noContent();
        }else{
            return $plantas;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre'=>'bail|required|string|min:5',
            'altura'=>'string',
            'perene'=>'boolean',
            'image'=>'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'=>'Los datos no cumplen con los requerimientos'],400);
        }else{
            $validated = $validator->validated();
            $planta = Plantas::create([
                'nombre' => $validated['nombre'],
                'altura' => $validated['altura'],
                'perene' => $validated['perene'],
            ]);
            if (strlen($request->image)>5){
                $planta->image()->create(['url'=>$request->input('image')]);
            }
            return response()->json($planta,201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $planta = Plantas::findOrFail($id);
        return response()->json(
            $planta
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $planta = Plantas::findOrFail($id);
        $planta->nombre = $request->input('nombre');
        $planta->altura = $request->input('altura');
        $planta->perene = $request->input('perene');
        $planta->save();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planta = Plantas::findOrFail($id);
        $planta->delete();
        return response()->noContent();
    }

    public function verComentarios($id)
    {
        $planta = Plantas::findOrFail($id);
        $comentarios = $planta->comentarios;
        return response()->json(
            $comentarios
        );
    }

    public function addUsuario(Request $request)
    {
        $user = $request->user();
        $planta = Plantas::findOrFail($request->input('planta_id'));
        $user->plantas()->attach($planta);
        return response()->json($user);
    }

}
