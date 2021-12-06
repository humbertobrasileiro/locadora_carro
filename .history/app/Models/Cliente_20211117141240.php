<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = ['nome'];

    public function rules() {
        return [
            'nome' => 'required|unique:clientes,nome,'.$this->id.'|min:3'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O cliente informado já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres'
        ];
    }

    public function locacoes() {
        return $this->belongsTo('App\Models\Locacao', 'cliente_id', 'id');
    }

}
