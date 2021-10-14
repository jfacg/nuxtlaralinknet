<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'address',
            'numberPorts',
            'signal',
            'project_id',
            'status'
    ];

    public function rules($id = '')
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255', "unique:projects,name,{$id},id"],
            'numberPorts' => ['required', 'numeric'],
            'project_id' => ['required', 'numeric']
        ];

        return $rules;
    }

    public function ports()
    {
        return $this->hasMany(Port::class,'box_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

   
}
