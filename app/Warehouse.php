<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
    
}
