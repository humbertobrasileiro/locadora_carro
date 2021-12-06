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

    public function listAll() {

        $carro = new Carro();
        $carros = $carro->orderBy('modelo_id', 'asc')->with(['modelo'])->get();

        return ['carros' => $carros];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $carroRepository = new CarroRepository($this->carro);

        if($request->has('atributos_modelo')) {

            $atributos_modelo = 'modelo:id,'.$request->atributos_modelo;
            $carroRepository->selAtribRegRelac($atributos_modelo);

        } else {

            $carroRepository->selAtribRegRelac('modelo');

        }

        if($request->has('atributos_locacoes')) {

            $atributos_locacoes = 'locacoes:id,'.$request->atributos_locacoes;
            $carroRepository->selAtribRegRelac($atributos_locacoes);

        } else {

            $carroRepository->selAtribRegRelac('locacoes');

        }

        if($request->has('filtro')) {

            $carroRepository->filtro($request->filtro);

        }

        if($request->has('atributos')) {

            $carroRepository->SelectAtributos($request->atributos);

        }

        return response()->json($carroRepository->getResultadoPaginado(5), 200);

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
     * @param  $id Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = $this->carro->with('modelo')->find($id);

        if ($carro === null) {
            return response()->json(['erro', 'Registro não encontrado'], 404);
        } else {
            return response()->json($carro, 200);
        }
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
        $carro = $this->carro->find($id);

        if ($carro === null) {

            return response()->json(['erro' => 'Registro não encontrado, sem atualização'], 404);

        } else {

            if ($request->method() === 'PATCH') {

                $dynamicRules = [];

                foreach ($carro->rules() as $key => $rule) {

                    if (array_key_exists($key, $request->all())) {
                        $dynamicRules[$key] = $rule;
                    }

                }

                $request->validate($dynamicRules, $carro->feedback());

            } else {

                $request->validate($carro->rules(), $carro->feedback());

            }

            $carro->fill($request->all());

            $carro->save();

            return response()->json($carro, 200);

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
        $carro = $this->carro->find($id);

        if ($carro === null) {
            return response()->json(['erro' => 'Registro não encontrado, nada foi removido'], 404);
        } else {

            $carro->delete();
            return response()->json(['msg' => 'O carro foi removido com sucesso!'], 200);

        }
    }
}
