<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'telefone',
        'email',
        'status',
        'usuario_id',
        'empresa_id'
    ];

    public function rules($id = '', $method = '')
    {
        $rules = [
            'cpf' => ['required', 'string', 'min:11'],
            'email' => ['required', 'string', 'email', 'min:3', 'max:255', "unique:watches,email,{$id},id"],
            'telefone' => ['required', 'string', 'min:11'],
        ];

        return $rules;
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
}
