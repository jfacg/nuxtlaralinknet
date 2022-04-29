<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $fillable = [
        'maquinaNome',
        'maquinaDescricao',
        'maquinaStatus',
    ];


    public function rules($id = '')
    {
        $rules = [
            'maquinaNome' => ['required', 'string', 'min:3', 'max:255', "unique:maquinas,maquinaNome,{$id},id"],
            'maquinaDescricao' => ['nullable'],
            'maquinaStatus' => ['required', 'string', 'min:3', 'max:255'],
        ];


        return $rules;
    }

}
