<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFlow extends Model
{
    protected $table = 'item_flows';

    protected $fillable = [
        'user_id', 'item_id', 'type', 'quantity'
    ];

    protected $hidden = [
        'created_date', 'updated_date',
    ];

    public function scopeSearch($query, $search){
        return $query->whereRaw('LOWER(`items`.`name`) LIKE ?', [
            '%'.strtolower($search).'%'
        ]);
    }

    public function getQuantityAttribute($value)
    {
        return abs($value);
    }

    public function scopeGetByItemId($query, $item_id){
        return $query->where('item_flows.item_id','=', $item_id);
    }


    public function scopeGetByType($query, $type){
        return $query
            ->select(
                'item_flows.id as id',
                'item_flows.item_id as item_id',
                'items.name as name',
                'items.amount as amount',
                'item_flows.quantity as quantity'
            )
            ->join('items', 'item_flows.item_id' ,'=', 'items.id')
            ->where('item_flows.type','=', $type);
    }
}
