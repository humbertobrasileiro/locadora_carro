<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->has('atributos_marca')) {

            $atributos_marca = $request->atributos_marca;
            $modelos = $this->modelo->with('marca:id,'.$atributos_marca);

        } else {

            $modelos = $this->modelo->with('marca');

        }

        if($request->has('filtro')) {

            $filtros = explode('|', $request->filtro);

            foreach ($filtros as $filtro) {

                $c = explode(':', $filtro);

                $modelos = $modelos->where($c[0], $c[1], $c[2]);

            }

        }

        if($request->has('atributos')) {

            $atributos = $request->atributos;
            $modelos = $modelos->selectRaw($atributos)->get();

        } else {

            $modelos = $modelos->get();

        }

        return response()->json($modelos, 200);

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

        $request->validate($this->modelo->rules() /*, $this->modelo->feedback() */);

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $dados = $request->all();

        $dados['imagem'] = $imagem_urn;

        $modelo = $this->modelo->create($dados);

        return response()->json($modelo, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if ($modelo === null) {
            return response()->json(['erro', 'Registro n??o encontrado'], 404);
        } else {
            return response()->json($modelo, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->find($id);

        if ($modelo === null) {

            return response()->json(['erro' => 'Registro n??o encontrado, sem atualiza????o'], 404);

        } else {

            if ($request->method() === 'PATCH') {

                $dynamicRules = [];

                foreach ($modelo->rules() as $key => $rule) {

                    if (array_key_exists($key, $request->all())) {
                        $dynamicRules[$key] = $rule;
                    }

                }

                $request->validate($dynamicRules /* , $marca->feedback() */);

            } else {

                $request->validate($modelo->rules() /* , $modelo->feedback() */);

            }

            $modelo->fill($request->all());

            if ($request->file('imagem')) {

                Storage::disk('public')->delete($modelo->imagem);

                $imagem = $request->file('imagem');

                $imagem_urn = $imagem->store('imagens/modelos', 'public');

                $modelo->imagem = $imagem_urn;

            }

            $modelo->save();

            return response()->json($modelo, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if ($modelo === null) {
            return response()->json(['erro' => 'Registro n??o encontrado, nada foi removido'], 404);
        } else {

            Storage::disk('public')->delete($modelo->imagem);

            $modelo->delete();

            return response()->json(['msg' => 'O modelo foi removido com sucesso!'], 200);
        }
    }
}
