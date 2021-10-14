<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'cableCode',
            'clientIxc_id',
            'box_id',
            'status',
            'partner'
    ];


    public function rules($id = '')
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255', "unique:ports,name,{$id},id"],
            'cableCode' => ['numeric', 'nullable', "unique:ports,cableCode,{$id},id"],
            'clientIxc_id' => ['numeric', 'nullable', "unique:ports,clientIxc_id,{$id},id"],
            'partner' => ['nullable', "unique:ports,partner,{$id},id"],
            'box_id' => ['required', 'numeric']
        ];

        return $rules;
    }

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id', 'id');
    }

    public function clientIxc()
    {
        return $this->belongsTo(Clientixc::class, 'clientIxc_id', 'id');
    }

    public function portBusyIxc($client)
    {
        return $port = $this->where('clientIxc_id', '=', $client)->get();

    }

    public function portBusyPartner($client)
    {
        return $port = $this->where('partner', '=', $client)->get();

    }


}
