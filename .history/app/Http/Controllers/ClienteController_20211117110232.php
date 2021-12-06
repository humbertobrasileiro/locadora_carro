<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $clienteRepository = new ClienteRepository($this->cliente);

        // if($request->has('atributos_locacoes')) {

        //     $atributos_locacoes = 'locacoes:id,'.$request->atributos_locacoes;
        //     $clienteRepository->selAtribRegRelac($atributos_locacoes);

        // } else {

        //     $clienteRepository->selAtribRegRelac('locacoes');

        // }

        if($request->has('filtro')) {

            $clienteRepository->filtro($request->filtro);

        }

        if($request->has('atributos')) {

            $clienteRepository->SelectAtributos($request->atributos);

        }

        return response()->json($clienteRepository->getResultado(), 200);

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

        $request->validate($this->cliente->rules(), $this->cliente->feedback());

        $dados = $request->all();

        $cliente = $this->cliente->create($dados);

        return response()->json($cliente, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->find($id); // ->with('locacao')

        if ($cliente === null) {
            return response()->json(['erro', 'Registro não encontrado'], 404);
        } else {
            return response()->json($cliente, 200);
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
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {

            return response()->json(['erro' => 'Registro não encontrado, sem atualização'], 404);

        } else {

            if ($request->method() === 'PATCH') {

                $dynamicRules = [];

                foreach ($cliente->rules() as $key => $rule) {

                    if (array_key_exists($key, $request->all())) {
                        $dynamicRules[$key] = $rule;
                    }

                }

                $request->validate($dynamicRules, $cliente->feedback());

            } else {

                $request->validate($cliente->rules(), $cliente->feedback());

            }

            $cliente->fill($request->all());

            $cliente->save();

            return response()->json($cliente, 200);

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
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'Registro não encontrado, nada foi removido'], 404);
        } else {

            $cliente->delete();
            return response()->json(['msg' => 'O cliente foi removido com sucesso!'], 200);

        }
    }
}
