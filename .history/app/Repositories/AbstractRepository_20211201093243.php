<?php

    namespace App\Repositories;

    use Illuminate\Database\Eloquent\Model;

    abstract class AbstractRepository
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

                echo $c;

                $this->model = $this->model->where($c[0], $c[1], $c[2]);

            }

        }

        public function SelectAtributos($atributos) {

            $this->model = $this->model->selectRaw($atributos);

        }

        public function getResultado() {
            return $this->model->get();
        }

        public function getResultadoPaginado($nPag) {
            return $this->model->paginate($nPag); // ->orderBy('created_at', 'desc')
        }

    }

?>
