<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $marcas = Marca::all(); Modo estático

        $marcas = $this->marca->all();

        return response()->json($marcas, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $marca = Marca::create($request->all()); - Modo estático

        $marca = $this->marca->create($request->all());

        return response()->json($marca, 201);
        // redirect()->route('marca.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro', 'Registro não encontrado'], 404);
        } else {
            return $marca;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Registro não encontrado, sem atualização'], 404);
        } else {
            $marca->update($request->all());
            return $marca;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Registro não encontrado, nada foi removido'], 404);
        } else {
            $marca->delete();
            return ['msg' => 'A marca foi removida com sucesso!'];
        }
    }
}
