<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betcopaanalise extends Model
{
    use HasFactory;

    protected $fillable = [
        'dicajogoe_id',
        'dicajogoc_id',
        'dicajogod_id',
        'jogoe_id',
        'jogoc_id',
        'jogod_id',
        'green',
        'tipo',
        'analise',
        'status',
    ];

    public function dicajogoe()
    {
        return $this->belongsTo(Betcopa::class, 'dicajogoe_id', 'id');
    }

    public function dicajogoc()
    {
        return $this->belongsTo(Betcopa::class, 'dicajogoc_id', 'id');
    }

    public function dicajogod()
    {
        return $this->belongsTo(Betcopa::class, 'dicajogod_id', 'id');
    }

    public function jogoe()
    {
        return $this->belongsTo(Betcopa::class, 'jogoe_id', 'id');
    }

    public function jogoc()
    {
        return $this->belongsTo(Betcopa::class, 'jogoc_id', 'id');
    }

    public function jogod()
    {
        return $this->belongsTo(Betcopa::class, 'jogod_id', 'id');
    }
}
