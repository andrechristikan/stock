<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    
    protected $table = 'items';

    protected $fillable = [
        'name', 'amount', 'photo', 'rack_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    
    public function getPhotoAttribute($value)
    {
        return $value ?? '';
    }

    public function getQuantityDefectAttribute($value)
    {
        return abs($value);
    }

    public function scopeGetAllItem($query){
        return $query->select(
            'items.id as id',
            'items.rack_id as rack_id',
            'racks.name as rack_name',
            'racks.warehouse_id as warehouse_id',
            'warehouses.name as warehouse_name',
            'items.name as name',
            'items.amount as amount',
            'items.photo as photo',
            DB::raw('( select SUM(quantity) from item_flows where item_flows.item_id = items.id and item_flows.type like "defect" ) as quantity_defect'),
            DB::raw('( select SUM(quantity) from item_flows where item_flows.item_id = items.id ) as quantity')
        )
            ->join('racks', 'items.rack_id', '=', 'racks.id')
            ->join('warehouses', 'racks.warehouse_id', '=', 'warehouses.id')
            ->having('quantity', '>', 0);
    }

    public function scopeSearch($query, $search){
        return $query->whereRaw('LOWER(`items`.`name`) LIKE ?', [
            '%'.strtolower($search).'%'
        ])->orWhereRaw('LOWER(`racks`.`name`) LIKE ?', [
            '%'.strtolower($search).'%'
        ])->orWhereRaw('LOWER(`warehouses`.`name`) LIKE ?', [
            '%'.strtolower($search).'%'
        ]);
    }

    public function scopeGetOneItemById($query, $id){
        return $query->select(
            'items.id as id',
            'items.rack_id as rack_id',
            'racks.name as rack_name',
            'racks.warehouse_id as warehouse_id',
            'warehouses.name as warehouse_name',
            'items.name as name',
            'items.amount as amount',
            'items.photo as photo',
            DB::raw('( select SUM(quantity) from item_flows where item_flows.item_id = items.id and item_flows.type like "defect" ) as quantity_defect'),
            DB::raw('( select SUM(quantity) from item_flows where item_flows.item_id = items.id ) as quantity')
        )
            ->join('racks', 'items.rack_id', '=', 'racks.id')
            ->join('warehouses', 'racks.warehouse_id', '=', 'warehouses.id')
            ->where('items.id', '=', $id)
            ->having('quantity', '>', 0);
    }

    public function scopeGetByRackId($query, $rack_id){
        return $query->where('items.rack_id','=', $rack_id);
    }

    public function scopeGetByWarehouseId($query, $warehouse_id){
        return $query->where('racks.warehouse_id','=', $warehouse_id);
    }


}
