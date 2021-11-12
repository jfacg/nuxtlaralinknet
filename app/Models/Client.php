<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Nullable;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'birthday',
        'cellPhone1',
        'cellPhone2',
        'email',
        'cep',
        'street',
        'number',
        'district',
        'city',
        'state',
        'complement',
    ];

    public function rules($id = '')
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'cpf' => ['required', 'string', "unique:clients,cpf,{$id},id"],
            'birthday' => ['nullable', 'date'],
            'cellPhone1' => ['required', 'string'],
            'cellPhone2' => ['nullable', 'string'],
            'email' => ['required','nullable', 'email', "unique:clients,email,{$id},id"],
            'cep' => ['required','string'],
            'street' => ['required','string', 'min:3', 'max:255'],
            'number' => ['required', 'int'],
            'district' => ['required','string', 'min:3', 'max:255'],
            'city' => ['required','string', 'min:3', 'max:255'],
            'state' => ['required','string', 'min:2', 'max:255'],
            'complement' => ['nullable', 'string', 'min:3', 'max:255'],
        ];

        return $rules;
    }


}
