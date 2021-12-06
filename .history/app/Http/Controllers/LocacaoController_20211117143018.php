<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{

    public function __construct(Locacao $locacao) {
        $this->locacao = $locacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $locacaoRepository = new LocacaoRepository($this->locacao);

        if($request->has('atributos_carro')) {

            $atributos_carro = 'carro:id,'.$request->atributos_carro;
            $locacaoRepository->selAtribRegRelac($atributos_carro);

        } else {

            $locacaoRepository->selAtribRegRelac('carro');

        }

        if($request->has('filtro')) {

            $locacaoRepository->filtro($request->filtro);

        }

        if($request->has('atributos')) {

            $locacaoRepository->SelectAtributos($request->atributos);

        }

        return response()->json($locacaoRepository->getResultado(), 200);

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

        $request->validate($this->locacao->rules(), $this->locacao->feedback());

        $dados = $request->all();

        $locacao = $this->locacao->create($dados);

        return response()->json($locacao, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locacao = $this->locacao->find($id); // ->with('marca')

        if ($locacao === null) {
            return response()->json(['erro', 'Registro não encontrado'], 404);
        } else {
            return response()->json($locacao, 200);
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
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {

            return response()->json(['erro' => 'Registro não encontrado, sem atualização'], 404);

        } else {

            if ($request->method() === 'PATCH') {

                $dynamicRules = [];

                foreach ($locacao->rules() as $key => $rule) {

                    if (array_key_exists($key, $request->all())) {
                        $dynamicRules[$key] = $rule;
                    }

                }

                $request->validate($dynamicRules /* , $marca->feedback() */);

            } else {

                $request->validate($locacao->rules() /* , $locacao->feedback() */);

            }

            $locacao->fill($request->all());

            if ($request->file('imagem')) {

                Storage::disk('public')->delete($locacao->imagem);

                $imagem = $request->file('imagem');

                $imagem_urn = $imagem->store('imagens/modelos', 'public');

                $locacao->imagem = $imagem_urn;

            }

            $locacao->save();

            return response()->json($locacao, 200);
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
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Registro não encontrado, nada foi removido'], 404);
        } else {

            $locacao->delete();

            return response()->json(['msg' => 'A locação foi removida com sucesso!'], 200);
        }
    }
}
