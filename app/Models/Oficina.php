<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    protected $table = 'oficina';

    protected $primaryKey = 'cod_oficina';

    public $timestamps = false;

    protected $fillable = [
        'nom_oficina',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [];
}
