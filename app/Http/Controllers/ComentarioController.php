<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Plantas;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, $planta_id)
    {
        $this->validate($request, array(
            'mensaje'=>'required|max:255',
        ));
        $planta = Plantas::findOrFail($planta_id);
        $comentario= new Comentario();
        $comentario->mensaje = $request->mensaje;
        $comentario->user_id = $request->user()->id;
        $comentario->plantas_id = $request->planta_id;
        $comentario->save();

        return response()->json([$planta,$comentario],200);
    }

}
