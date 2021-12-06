<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];

    public function rules() {
        return [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required',
            'disponivel' => 'required|boolean',
            'km' => 'required|integer'
        ];
    }

    public function feedback() {
        return [
            'modelo_id.exists' => 'O modelo informado não foi cadastrado',
            'required' => 'O campo :attribute deve ser informado',
            'disponivel.boolean' => 'Informe o carro corretamente',
            'km.integer' => 'O km deve ser informado com um número inteiro'
        ];
    }

    public function modelo() {
         return $this->belongsTo('App\Models\Modelo');
    }

}
