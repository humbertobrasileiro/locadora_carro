<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

    class MarcaRepository
    {
        public function __construct($model)
        {
            $this->model = $model;
        }
    }

?>
