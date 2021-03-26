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
        'updated_at',
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
        return $query->orWhere('item_flows.type','=', $type);
    }

    public function scopeJoinItem($query){
        return $query
            ->select(
                'item_flows.id as id',
                'item_flows.item_id as item_id',
                'items.name as name',
                'items.amount as amount',
                'item_flows.type as type',
                'item_flows.quantity as quantity',
                'item_flows.created_at as created_at'
            )
            ->join('items', 'item_flows.item_id' ,'=', 'items.id');
    }

    public function scopeInDateRange($query, $from, $to){
        return $query->whereBetween('item_flows.created_at', [$from, $to]);
    }

    public function scopeSortDescByCreatedAt($query){
        return $query->sortaBy([
            'item_flows.created_at' => 'desc'
        ]);
    }

}
