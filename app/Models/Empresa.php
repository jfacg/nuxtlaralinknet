<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'filialixc'
    ];

    public function rules($id = '')
    {
        $rules = [
            'nome' => ['required', 'string', 'min:3', 'max:255', "unique:empresas,nome,{$id},id"],
            'descricao' => ['required', 'string', 'min:3', 'max:255'],
        ];


        return $rules;
    }
}
