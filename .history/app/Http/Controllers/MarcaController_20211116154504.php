<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function index(Request $request)
    {
        if($request->has('atributos_modelos')) {

            $atributos_modelos = $request->atributos_modelos;
            $marcas = $this->marca->with('modelos:id,'.$atributos_modelos);

        } else {

            $marcas = $this->marca->with('modelos');

        }

        if($request->has('filtro')) {

            $filtros = explode('|', $request->filtro);

            foreach ($filtros as $filtro) {

                $c = explode(':', $filtro);

                $marcas = $marcas->where($c[0], $c[1], $c[2]);

            }

        }

        if($request->has('atributos')) {

            $atributos = $request->atributos;

            $marcas = $marcas->selectRaw($atributos)->get();

        } else {

            $marcas = $marcas->get();

        }

        return response()->json($marcas, 200);
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

        $request->validate($this->marca->rules(), $this->marca->feedback());

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens', 'public');

        $dados = $request->all();

        $dados['imagem'] = $imagem_urn;

        $marca = $this->marca->create($dados);

        return response()->json($marca, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);

        if ($marca === null) {
            return response()->json(['erro', 'Registro n??o encontrado'], 404);
        } else {
            return response()->json($marca, 200);
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
        $marca = $this->marca->find($id);

        if ($marca === null) {

            return response()->json(['erro' => 'Registro n??o encontrado, sem atualiza????o'], 404);

        } else {

            if ($request->method() === 'PATCH') {

                $dynamicRules = [];

                foreach ($marca->rules() as $key => $rule) {

                    if (array_key_exists($key, $request->all())) {
                        $dynamicRules[$key] = $rule;
                    }

                }

                $request->validate($dynamicRules, $marca->feedback());

            } else {

                $request->validate($marca->rules(), $marca->feedback());

            }

            $marca->fill($request->all());

            if ($request->file('imagem')) {

                Storage::disk('public')->delete($marca->imagem);

                $imagem = $request->file('imagem');

                $imagem_urn = $imagem->store('imagens', 'public');

                $marca->imagem = $imagem_urn;

            }

            $marca->save();

            return response()->json($marca, 200);

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
            return response()->json(['erro' => 'Registro n??o encontrado, nada foi removido'], 404);
        } else {

            Storage::disk('public')->delete($marca->imagem);

            $marca->delete();
            return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
        }
    }
}
