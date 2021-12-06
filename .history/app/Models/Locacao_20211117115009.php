<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    use HasFactory;

    protected $table = 'locacoes';
    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_inicio_periodo',
        'data_final_previsto_periodo',
        'data_final_realizado_periodo',
        'valor_diaria',
        'km_inicial',
        'km_final'
    ];

    public function rules() {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'carro_id' => 'required|exists:carros,id',
            'data_inicio_periodo' => 'required',
            'data_final_previsto_periodo' => 'required',
            'valor_diaria' => 'required|integer',
            'km_inicial' => 'required|integer'
        ];
    }

    public function feedback() {
        return [
            'cliente_id.exists' => 'O cliente informado não foi cadastrado',
            'carro_id.exists' => 'O carro informado não foi cadastrado',
            'required' => 'O campo :attribute deve ser informado',
            'valor_diaria.integer' => 'Deve ser informado um valor ou zero para cortesia',
            'km_inicial.integer' => 'O km inicial deve ser informado com um número inteiro'
        ];
    }


    public function clientes() {
        $this->hasMany('App\Models\Cliente', 'locacoes');
    }

    public function carros() {
        $this->belongsTo('App\Models\Carro');
    }

}
