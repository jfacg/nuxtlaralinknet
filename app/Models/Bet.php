<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = [
        'liga',
        'data',
        'hora',
        'minuto',
        'placar',
    ];

    public function rules($id = '')
    {
        $rules = [
            // 'name' => ['required', 'string', 'min:3', 'max:255', "unique:projects,name,{$id},id"],
            // 'numberPorts' => ['required', 'numeric'],
            // 'project_id' => ['required', 'numeric']
        ];

        return $rules;
    }
}
