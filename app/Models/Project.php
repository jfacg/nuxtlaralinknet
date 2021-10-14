<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'shortName',
            'description',
            'numberBoxes',
            'numberBoxPorts',
            'oltName',
            'oltSlot',
            'oltPort',
    ];

    public function rules($id = '')
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255', "unique:projects,name,{$id},id"],
            'shortName' => ['required', 'string', 'min:3', 'max:255', "unique:projects,shortName,{$id},id"],
            'description' => ['string', 'min:3', 'max:255'],
            'numberBoxes' => ['required', 'numeric'],
            'numberBoxPorts' => ['required', 'numeric'],
            'oltName' => ['required', 'string', 'min:3', 'max:255'],
            'oltSlot' => ['required', 'numeric'],
            'oltPort' => ['required', 'numeric'],
        ];


        return $rules;
    }

    public function boxes()
    {
        return $this->hasMany(Box::class,'project_id', 'id');
    }
}
