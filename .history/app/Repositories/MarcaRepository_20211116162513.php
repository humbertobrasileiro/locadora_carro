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
            $this->model->with($atributos);
        }
    }

?>
