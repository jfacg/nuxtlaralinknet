<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betsuperanalise extends Model
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
        return $this->belongsTo(Betsuper::class, 'dicajogoe_id', 'id');
    }

    public function dicajogoc()
    {
        return $this->belongsTo(Betsuper::class, 'dicajogoc_id', 'id');
    }

    public function dicajogod()
    {
        return $this->belongsTo(Betsuper::class, 'dicajogod_id', 'id');
    }

    public function jogoe()
    {
        return $this->belongsTo(Betsuper::class, 'jogoe_id', 'id');
    }

    public function jogoc()
    {
        return $this->belongsTo(Betsuper::class, 'jogoc_id', 'id');
    }

    public function jogod()
    {
        return $this->belongsTo(Betsuper::class, 'jogod_id', 'id');
    }
}
