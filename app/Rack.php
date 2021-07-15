<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{

    protected $table = 'racks';

    protected $fillable = [
        'name', 'warehouse_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function scopeGetAll($query){
        return $query->select(
            'racks.id as id',
            'racks.name as rack_name',
            'racks.warehouse_id as warehouse_id',
            'warehouses.name as warehouse_name'
        )
            ->join('warehouses', 'racks.warehouse_id', '=', 'warehouses.id');
    }

    public function scopeGetByWarehouseId($query, $warehouse_id){
        return $query->where('racks.warehouse_id','=', $warehouse_id);
    }
}
