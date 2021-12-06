<?php

    namespace App\Repositories;

    use Illuminate\Database\Eloquent\Model;

    class MarcaRepository
    {
        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function selAtribRegRelac($atributos) {
            $this->model = $this->model->with($atributos);
        }

        public function filtro($filtros) {

            $condicoes = explode('|', $filtros);

            foreach ($condicoes as $condicao) {

                $c = explode(':', $condicao);

                $this->model = $this->model->where($c[0], $c[1], $c[2]);

            }

        }

        public function SelectAtributos($atributos) {

            $this->model = $this->model->selectRaw($atributos)->get();

        }
    }

?>
