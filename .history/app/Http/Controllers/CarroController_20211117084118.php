<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;

class CarroController extends Controller
{

    public function __construct(Carro $carro) {
        $this->carro = $carro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $carroRepository = new CarroRepository($this->carro);

        if($request->has('atributos_modelos')) {

            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $carroRepository->selAtribRegRelac($atributos_modelos);

        } else {

            $carroRepository->selAtribRegRelac('modelos');

        }

        if($request->has('filtro')) {

            $carroRepository->filtro($request->filtro);

        }

        if($request->has('atributos')) {

            $carroRepository->SelectAtributos($request->atributos);

        }

        return response()->json($carroRepository->getResultado(), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validando os dados a serem gravados

        $request->validate($this->carro->rules(), $this->carro->feedback());

        $dados = $request->all();

        $carro = $this->carro->create($dados);

        return response()->json($carro, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show(Carro $carro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carro $carro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carro $carro)
    {
        //
    }
}
